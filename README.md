# Design pattern phần 3

Đề bài: Create Query Builder is a simple, methods-chaining dependency-free library to create SQL Queries simple.
Supports databases which are supported by PDO

**Người thực hiện** : Vu Van Nghia

**Download và run code** tại đường
dẫn [https://github.com/vn0202/demo_simple_query_builder](https://github.com/vn0202/demo_simple_query_builder)

#### install

 ```php
composer require vannghia/simple_query_builder
```

#### Sử dụng

- Sử dụng autoload composer
- Cấu hình thông tin database trong `$config`

```php 
$config = [
    'driver'=>'mysql',
    'host'=>'localhost',
    'dbname'=>'app',
    'username'=>'root',
    'password'=>'root',
];
Connection::$config = $config;

```

- Trong thư mục `src\Model`, thêm các file model có cấu trúc như sau:

```php
<?php
namespace Vannghia\TestNghia\Model;
use Vannghia\SimpleQueryBuilder\Model;

class TblAdmin extends Model{
   // $table chứa tên bảng cần truy xuất dữ liệu 
    protected  $table = 'tbl_admin';

}
```

- Khi đó, để truy xuất dữ liệu từ bảng `tbl_admin`:


  - Lấy bản ghi đầu tiên: 
   ```php 
      $test = TblAdmin::first();
      $test = TblAdmin::where(['id','>',20])->first()// lấy bản ghi đầu tiên có id > 20
   ```
  - Lấy số lượng bản ghi: 
   

   ```php 
   $test = TblAdmin::count();//trả về tổng số bản ghi 
   $test = TblAdmin::where(['id','>',20])->count();
   ```
  - Chọn các giá trị cần lấy ( mặc định trả về gía trị của tất cả các cột )
  
   ```php 
   $test = TblAdmin::select(['email','phone'])->get();//chỉ tra ve gia tri cua cot email và phone 
   ```
   - Lựa chọn có điều kiện: 

   ```php 
   $test = TblAdmin::where(['id','>',20])->where(['email','=','nghiavuxp0202@gmail.com'])->get();
   or $test = TblAdmin::where(['id','>',20],['email','=','nghiavuxp0202@gmail.com])->get();
   
   ```
   - Sắp xếp gía trị trả về: 
   
     ```php 
     $test = TblAdmin::where(['id','>',10])->orderBy(['email'],'desc')->get();
     ```
   - kết hợp bảng : 

     ```php 
     $test = TblAdmin::join('tbl_product',['tbl_product.creator','=','tbl_admin.id'])
                   ->where(['id','>',20])
                   ->get();
     $test = TblAdmin::rightjoin('tbl_product',['tbl_product.creator','=','tbl_admin.id'])
                   ->where(['id','>',20])
                   ->get();
    $test = TblAdmin::lefttjoin('tbl_product',['tbl_product.creator','=','tbl_admin.id'])
                   ->where(['id','>',20])
                   ->get();

     ```
   - Chèn bản ghi:

  ```php 
  $data = [
    'fullname'=>'vnpgroup'
    'username'=>'VNPGROUP',
    'password'=>md5('vnp'),
    'email'=>'vnp@gmail.com',
    'phone'=>123456789,
    'address'=>'102 Thai Thinh',
    'reg_date'=>time(),
    'role'=>1,
    'amdin_intro'=>2,
    ];
TblAdmin::create($data)// Chen ban ghi vao bang 
TblAdmin::insert($data)

  ```
   - Cập  nhật bản ghi: 

   ```php 
   $data = [
   'fullname'=>'VNP',
   'email'=>'vnp@gmail.com'
   ];
   
   TblAdmin::where(['id','=',43])->update($data);
   ```
   - xóa bản ghi: 
   
   ```php 
   //xoa ban ghi 
    TblAdmin::where(['id','=',44])->delete();

   ```

 **Có thể sử dụng trực tiếp QueryBuilder**  

  ```php 
   DB::table('tbl_admin')->where(['id','=',20])->get();
  ```


```php 

require  "vendor/autoload.php";

use Vannghia\SimpleQueryBuilder\Config\Connection;
use Vannghia\TestNghia\Model\TblAdmin;

$config  = [
    'driver'=>'mysql',
    'host'=>'localhost',
    'dbname'=>'app',
    'username'=>'root',
    'password'=>'root',

];
Connection::$config = $config;

// lay ban ghi dau tien 
$test = TblAdmin::select(['email'])
       ->first();
// lay tat ca ban ghi 

$test = TblAdmin::get(); 




$test = TblAdmin::where(['id','>',20], ['email','=','nghiavuxp0202@gmail.com'))->limit(10,5)->get()
$test = TblAdmin::where(['id','=',1])
                   ->select(['email','phone'])
                   ->get();

//output 
object(Vannghia\SimpleQueryBuilder\Collection)#5 (1) {
  ["elements":"Vannghia\SimpleQueryBuilder\Collection":private]=>
  array(1) {
    [0]=>
    object(Vannghia\TestNghia\Model\TblAdmin)#6 (5) {
      ["original":protected]=>
      array(0) {
      }
      ["casts":protected]=>
      array(0) {
      }
      ["attributes":"Vannghia\SimpleQueryBuilder\Data":private]=>
      array(2) {
        ["email"]=>
        string(23) "nghiavuxp0202@gmail.com"
        ["phone"]=>
        string(10) "0981473790"
      }
      ["query"]=>
      object(Vannghia\SimpleQueryBuilder\QueryBuilder\QueryBuilder)#7 (9) {
        ["conn":"Vannghia\SimpleQueryBuilder\QueryBuilder\QueryBuilder":private]=>
        object(PDO)#8 (0) {
        }
        ["where":"Vannghia\SimpleQueryBuilder\QueryBuilder\QueryBuilder":private]=>
        string(0) ""
        ["whereCondition":"Vannghia\SimpleQueryBuilder\QueryBuilder\QueryBuilder":private]=>
        array(0) {
        }
        ["prepare":"Vannghia\SimpleQueryBuilder\QueryBuilder\QueryBuilder":private]=>
        NULL
        ["orderBy":"Vannghia\SimpleQueryBuilder\QueryBuilder\QueryBuilder":private]=>
        string(0) ""
      
        ["limit":"Vannghia\SimpleQueryBuilder\QueryBuilder\QueryBuilder":private]=>
        string(0) ""
        ["join":"Vannghia\SimpleQueryBuilder\QueryBuilder\QueryBuilder":private]=>
        string(0) ""
      }
      ["table":protected]=>
      string(9) "tbl_admin"
    }
  }
}
//

```
  
