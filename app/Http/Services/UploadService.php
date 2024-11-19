<?php


namespace App\Http\Services;


class UploadService
{
    public function store($request)
    {
        if ($request->hasFile('file')) {
            try {
                $name = $request->file('file')->getClientOriginalName();
                //Thư mục lưu trữ là 'uploads/Y/m/d' với ymd là năm tháng ngày
                //$pathFull = 'uploads/' . date("Y/m/d");
                $pathFull = 'uploads/images'; // Thư mục lưu trữ là 'uploads/images'

                $request->file('file')->storeAs(
                    'public/' . $pathFull, $name
                );

                return '/storage/' . $pathFull . '/' . $name;
            } catch (\Exception $error) {
                return false;
            }
        }
    }
}
