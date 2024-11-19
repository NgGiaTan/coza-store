<?php


namespace App\Http\Services;


use App\Jobs\SendMail;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function create($request)
    {
        $qty = (int)$request->input('num_product');
        $product_id = (int)$request->input('product_id');

        if ($qty <= 0 || $product_id <= 0) {
            Session::flash('error', 'Số lượng hoặc Sản phẩm không chính xác');
            return false;
        }

        $carts = Session::get('carts');
        if (is_null($carts)) {
            Session::put('carts', [
                $product_id => $qty
            ]);
            return true;
        }

        $exists = Arr::exists($carts, $product_id);
        if ($exists) {
            $carts[$product_id] = $carts[$product_id] + $qty;
            Session::put('carts', $carts);
            return true;
        }

        $carts[$product_id] = $qty;
        Session::put('carts', $carts);

        return true;
    }

    public function update($request)
    {
        Session::put('carts', $request->input('num_product'));

        return true;
    }
    
    public function getProduct()
    {
        $carts = Session::get('carts');
        if (is_null($carts)) return [];

        $productId = array_keys($carts);
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();
    }
    public function remove($id)
    {
        $carts = Session::get('carts');
        unset($carts[$id]);

        Session::put('carts', $carts);
        return true;
    }

    public function addCart($request)
    {
        try {
            DB::beginTransaction(); // Bắt đầu transaction để đảm bảo tính nhất quán

            $carts = Session::get('carts'); // Lấy giỏ hàng từ session

            if (is_null($carts)) {
                return false; // Nếu giỏ hàng trống, trả về false
            }

            // Tạo khách hàng mới từ thông tin request
            $customer = Customer::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'content' => $request->input('content')
            ]);

            // Giảm số lượng tồn kho cho từng sản phẩm trong giỏ hàng
            foreach ($carts as $productId => $qty) {
                $product = Product::find($productId); // Tìm sản phẩm theo ID

                if ($product) {
                    // Kiểm tra nếu tồn kho đủ để giảm
                    if ($product->in_stock >= $qty) {
                        // Trừ số lượng tồn kho và lưu lại
                        $product->in_stock -= $qty;
                        $product->save(); // Lưu thông tin sản phẩm với số lượng tồn kho mới
                    } else {
                        // Nếu tồn kho không đủ, rollback transaction và thông báo lỗi
                        DB::rollBack();
                        Session::flash('error', 'Số lượng tồn kho không đủ cho sản phẩm: ' . $product->name);
                        return false;
                    }
                } else {
                    // Nếu không tìm thấy sản phẩm, rollback và thông báo lỗi
                    DB::rollBack();
                    Session::flash('error', 'Sản phẩm không tồn tại');
                    return false;
                }
            }

            // Nếu không có lỗi, commit transaction
            DB::commit();

            // Thông báo thành công
            Session::flash('success', 'Đặt Hàng Thành Công');

            // Gửi email qua Queue
            SendMail::dispatch($request->input('email'))->delay(now()->addSeconds(2));

            // Xóa giỏ hàng sau khi đặt hàng thành công
            Session::forget('carts');
        } catch (\Exception $err) {
            // Nếu có lỗi, rollback transaction và thông báo lỗi
            DB::rollBack();
            Session::flash('error', 'Đặt Hàng Lỗi, Vui lòng thử lại sau');
            return false;
        }

        return true;
    }

    protected function infoProductCart($carts, $customer_id)
    {
        $productId = array_keys($carts);
        $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();

        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'customer_id' => $customer_id,
                'product_id' => $product->id,
                'qty'   => $carts[$product->id],
                'price' => $product->price_sale != 0 ? $product->price_sale : $product->price,
            ];
        }

        return Cart::insert($data);
    }

    public function getCustomer()
    {
        return Customer::orderByDesc('id')->paginate(15);
    }

    public function getProductForCart($customer)
    {
        return $customer->carts()->with(['product' => function ($query) {
            $query->select('id', 'name', 'thumb');
        }])->get();
    }
}
