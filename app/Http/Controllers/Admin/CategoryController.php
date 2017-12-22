<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Entity\Category;
use Illuminate\Http\Request;
use App\Models\M3Result;

class CategoryController extends Controller
{

    /**
     * 分类显示页
     * @return [type] [description]
     */
    public function toCategory()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        foreach ($categories as $v) {
            if($v->parent_id != null && $v->parent_id != '') {
                $v->parent = Category::find($v->parent_id);
            }
        }
        return view('admin.category')->with('categories', $categories);
    }

    /**
    * 添加分类页面
    * @return [type] [description]
    */
    public function  toCategoryAdd() 
    {
        $categories = Category::where('parent_id',0)->get();
        return view('admin/category_add')->with('categories', $categories);
    }


    /**
    * 编辑分类页面
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    public function toCategoryEdit(Request $request) 
    {
        $id = $request->input('id', '');
        $category = Category::find($id);
        $categories = Category::where('parent_id',0)->get();
        return view('admin/category_edit')->with(['category' => $category, 'categories' => $categories]);
    }

    /**
    * 添加商品分类
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    public function categoryAdd(Request $request) 
    {
        $category = new Category;

        $category->name = $request->input('name', '');
        $category->category_no = $request->input('category_no', '');
        $category->parent_id = $request->input('parent_id', 0);
        $category->img_url = $request->input('img_url');
        $category->save();

        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = '添加成功';

        return $m3_result->toJson();
    }

    /**
     * 删除分类
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function categoryDel(Request $request) {
        $id = $request->input('id', '');
        Category::find($id)->delete();

        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = '删除成功';

        return $m3_result->toJson();
    }

    /**
     * 执行分类编辑
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function categoryEdit(Request $request) {
        $id = $request->input('id', '');
        $category = Category::find($id);

        $name = $request->input('name', '');
        $category_no = $request->input('category_no', '');
        $parent_id = $request->input('parent_id', '');

        $category->name = $name;
        $category->img_url = $request->input('img_url');
        $category->category_no = $category_no;
        if($parent_id != '') {
          $category->parent_id = $parent_id;
        }

        $category->save();
        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = '编辑成功';

        return $m3_result->toJson();
    }
}
