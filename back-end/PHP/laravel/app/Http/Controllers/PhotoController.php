<?php

namespace App\Http\Controllers;

use App\Http\Models\Image;
use App\Http\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhotoController extends Controller
{
    //获取照片列表数据
    public function getList(Request $request,Image $image)
    {
        $list = $image->photoImage();
        return $list->isNotEmpty()?renderSuccess('获取照片列表成功',$list)
            :renderError('暂无照片列表数据');
    }

    //删除照片
    public function destroy(Request $request,Photo $photo)
    {
        $data = $this->validate($request,['id'=>'required|integer']);
        try
        {
            DB::transaction(function () use ($photo, $data) {
                $where = [
                    'image_type'=>$this->image_type,
                    'image_id'  =>$data['id']
                ];
                Image::where($where)->delete();
                $photo->destroy($data['id']);
            });
            return renderSuccess('删除照片成功');
        } catch (\Exception $e)
        {
            return renderError('删除照片失败,请稍后再试！');
        }
    }

    //添加照片
    public function store(Request $request,Photo $photo)
    {
        $data = $this->validate($request,[
            'image_url'=>'required|url'
        ]);
        try
        {
            DB::transaction(function () use ($photo, $data) {
                $res = $photo->create();
                $res->images()->create(['image_url' => $data['image_url']]);
            });
            return renderSuccess('添加照片成功');
        } catch (\Exception $e)
        {
            return renderError('添加照片失败,请稍后再试!');
        }
    }

    //修改照片
    public function update(Request $request,Image $image)
    {
        $data = $this->validate($request,[
            'id'=>'required|integer',
            'image_url'=>'required|url'
        ]);
        $where = [
            'image_type'=>$this->image_type,
            'image_id'  =>$data['id']
        ];
        $res = $image->where($where)->update(['image_url'=>$data['image_url']]);
        return $res?renderSuccess('修改照片成功')
            :renderError('修改照片失败,请稍后再试！');
    }
}
