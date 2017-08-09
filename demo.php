<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use validate;

class demo extends Controller
{
    public function demo1()
    {
         $data=DB::table('xm_mine')->paginate(5);
    	 return view('demo1',['data'=>$data]);
    }


    public function demo2(Request $request)
    {
    	$ddd=$request->only(['uname','age','class','sex','marrage','email']);
    
        $this->validate($request,[
            'uname'=>'required|max:255',
            'age'=>'required|integer|between:0,150',
            'class'=>'required',
            'email'=>'required'
            ],
            [
                'uname.required'=>'名字不能为空',
                'age.required'=>'年龄不能为空',
                'age.between'=>'不能大于150',
                'class.required'=>'班级不能为空',
               'email.required'=>'邮件不能为空'

            ]
            );
            $path=$request->file('img');//接受文件（包括文件所有属性）
            $dir=$path->store('uploads');//给接收的文件起名字
            $destinationPath='uploads';//
            $bool=$path->move($destinationPath,$dir);//吧接受过来的文件（$dir）放在$destinationPath(uploads)下
            var_dump($bool);
            $ddd['img']=$dir;
             $bool=DB::table('xm_mine')->insert($ddd);

             return redirect()->action('demo@demo1');
    }

    public function demo3(Request $request, $id="")
    {
       if($request->isMethod('get'))
       {    
             //echo 'ddddd';
             $data=DB::table('xm_mine')->where(['id'=>$id])->first();
            //dd($data);
            return view('demo3',['data'=>$data]);
       } 
       else
       {
             $data=$request->only(['uname','age','class','sex','marrage','email']); 
             $id=$request->input('id'); 
             $bool=DB::table('xm_mine')->where(['id'=>$id])->update($data);
             if($bool){
             return redirect()->action('demo@demo1');
         }
       }
    }



    public function demo4($id='')
    {
        $data=DB::table('xm_mine')->where(['id'=>$id])->first();
        dd($data);
    }
}
