<?php

namespace App\Handlers;

use Illuminate\Support\Str;

class ImageUploadHandler
{
    //只允许一下后缀名的图片文件上传
    protected $allowed_ext = ['png','jpg','gif','jpeg'];

    public function save($file,$folder,$file_prefix)
    {
        //构建存储的文件夹规则，值如：uploads/images/avatars/201709/21/
        //文件夹切割能让文件查找效率更高
        $folder_name = "uploads/images/$folder/".date("Ym/d",time());
        //文件存储的具体路径
        $upload_path = public_path().'/'.$folder_name;

        //获取文件的后缀名，因图片从剪切板里黏贴时后缀名为空，此处保证后缀名一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        //拼接文件名，加前缀提高辨识度，前缀是相关模型ID
        $file_name = $file_prefix.'_'.time().'_'.Str::random(10).'.'.$extension;

        if(! in_array($extension,$this->allowed_ext))
        {
            return false;
        }

        $file->move($upload_path,$file_name);

        return [
            'path' => config('app.url')."/$folder_name/$file_name",
        ];

    }

    


}