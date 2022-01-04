## README


>>>
##Generate custom Unique ID or Code (With Prefix or Suffix Or Both Or Only Unique Id) Or reset your ID after change of Prefix or Suffix Or Both  in laravel framework
=======


# Installation

    composer require sirajcse/laravel-unique-id-generator

##### How to use it? You can use it in your controller code like as a helper or inside your model by defining a boot method.

## @@Unique ID/Code Generatore Like@@@

Inv-000001/12/21

    'table' => 'invoices' [sting table name]
    'field'=>'invoice_id' [Default 'id'] [Optional][any string field name]
    'length' => 12 [Integer value Id length]
    'prefix'=>'Inv-' [Default ''] [Optional] [any string]
    'suffix'=>date('/m/y') [Default ''] [Optional][any string]
    'reset_on_change'=>false[ Default false] [Optional] [Options are 1.prefix , 2.suffix 3.both 4.false]
    uniqueId=000001


###### Default field Default field value id; [like 'field'=>'id'] If need 'code' field in a table; 'field'=>'code'
###### Prefix Or Suffix Default Value Prefix=>'' or Suffix=>'';
###### Reset On Change If you want to reset value at the beginning of every prefix or suffix or both changes then set it value; [reset_on_change has 4 option prefix,suffix,both,false] Default Value reset_on_change= false;

## Example with controller

    Import ID generator for Prefix
    use sirajcse\UniqueIdGenerator\UniqueIdGenerator;

### For Prefix

    public function store(Request $request){
        $id = UniqueIdGenerator::generate(['table' => 'todos', 'length' => 6, 'prefix' => date('y')]);
        $todo = new Todo();
        $todo->id = $id;
        $todo->title = $request->get('title');
        $todo->save();
    }
    // 210001 210002 220003 230004

### For Suffix

    public function store(Request $request){
        $id = UniqueIdGenerator::generate(['table' => 'todos', 'length' => 6, 'suffix' => date('y')]);
        $todo = new Todo();
        $todo->id = $id;
        $todo->title = $request->get('title');
        $todo->save();
    }
    // 000121 000221 000322 000422

### For Both Prefix and Suffix

    public function store(Request $request){
        $id = UniqueIdGenerator::generate(['table' => 'todos', 'length' => 10,'prefix' => 'Inv-', 'suffix' => date('y')]);
        $todo = new Todo();
        $todo->id = $id;
        $todo->title = $request->get('title');
        $todo->save();
    }
    // Inv-000121 Inv-000221 Inv-000322 Inv-000422
    
  

### N.B: If you generate ID to the table id field then you must have to set the id field as fillable and public $incrementing = false; inside your model.

### Example with the model

In your model add a boot method. The ID will automatically generate when a new record will be added.
Associative array for 'prefix', 'suffix' add if needed

    public static function boot() { 
    parent::boot(); 
    self::creating(function ($model) { 
    $model->uuid = UniqueIdGenerator::generate(['table' => $this->table, 'length' => 10,'prefix' =>'Inv-', 'suffix' =>date('y')]); 
    }); 
    }
    // Inv-000121 Inv-000221 Inv-000322 Inv-000422

## Parameters
You must pass an associative array into generate function with table, length, prefix,suffix key.
            
            table = Your table name. Like 'users','invoice'
            field = Optional. By default, it works on the id field. You can set other field names also.like 'code', 'invoice_id', 'student_uuid'
            length = Your ID/Code length is total length **[ length= prefix+ unique id + suffif ]**
            prefix = Optional. By default, it prefix is empty. Define your prefix if your need. It can be a year prefix, month ,any custom letter or empty.
            suffix = Optional. By default, it suffix is empty. Define your suffix if your need. It can be a year suffix, month or any custom letter or empty
            reset_on_change = Optional, default false. If you want to reset id from 1 on prefix,suffix or both changes then set it prefix,suffix,both,false.
                        'reset_on_change'=>'prefix' Only Changes of prefix value reset
                        'reset_on_change'=>'suffix' Only Changes of suffix value reset
                        'reset_on_change'=>'both' Changes of both prefix and suffix value reset
                        'reset_on_change'=>'false' Optional. By default, it reset_on_change is false.
                        
    
#### Example: 01

    $config = [ 'table' => 'todos', 'length' => 6, 'prefix' => date('y') 'suffix' => '' ];
    // now use it $id = UniqueIdGenerator::generate($coFnfig);


#### Example 02: Only unique id/code with out Prefix, Suffix
// use within single line code

    $id = UniqueIdGenerator::generate(['table' => 'todos', 'length' => 6]);
    // output: 000001, 0000002

#### Example 03: INV-000001 for prefix string.
 Your field must be varchar.

    $id = UniqueIdGenerator::generate(['table' => 'invoices', 'length' => 10, 'prefix' =>'INV-']);
    //output: INV-000001 ,INV-000002

#### Example 04: 000001/2021 for suffix string.

    $id = UniqueIdGenerator::generate(['table' => 'invoices', 'length' => 10, 'suffix' =>date('/Y')]);
    //output: 00001/2021, 00002/2021 

#### Example 05: INV-000001/2021 for prefix,suffix (both) string.
        
    `$id = UniqueIdGenerator::generate(['table' => 'invoices', 'length' => 14,'prefix' =>'INV-', 'suffix' =>date('/Y')]);
    //output: INV-00001/2021, INV-00002/2021`

#### Example 06: By default (ID field),
 this package works on the ID field. You can set another field to generate an ID. Make sure your selected field must be unique and also proper data type.

    $id = UniqueIdGenerator::generate(['table' => 'products','field'=>'pid', 'length' => 6, 'prefix' =>date('P')]);
    //output: P00001 

#### Example 07: By default (reset your ID), 
    This package won't reset your ID when you change your prefix,suffix or Both of ID. 
    If you want to reset your ID from 1 on every prefix changes then pass reset_on_change => 'prefix' 
    If you want to reset your ID from 1 on every suffix changes then pass reset_on_change => 'suffix' 
    If you want to reset your ID from 1 on every prefix and suffix (both) changes then pass reset_on_change => 'both'___

#### Example 08: Reset Prefix ID yearly

    $id = UniqueIdGenerator::generate(['table' => 'invoices', 'length' => 10, 'prefix' =>date('y'), 'reset_on_change'=>'prefix']);
    //output: 2000000001,2000000002,2000000003
    //output: 2100000001,2100000002,2100000003

#### Example 09: Reset ID monthly

    $id = UniqueIdGenerator::generate(['table' => 'invoices', 'length' => 10, 'prefix' =>date('ym'),, 'reset_on_change'=>'prefix']]);
    //output: 1912000001,1912000002,1912000003
    //output: 2001000001,2001000002,2001000003

#### Example 10: Or any prefix change

        $id = UniqueIdGenerator::generate(['table' => 'products', 'length' => 6, 'prefix' => $prefix, 'reset_on_change'=>'prefix']]);
        //output: A00001,A00002,B00001,B00002

#### Example 11: Reset Suffix ID yearly

    `$id = UniqueIdGenerator::generate(['table' => 'invoices', 'length' => 10, 'suffix' =>date('y'),'reset_on_change'=>'suffix']]);
    //output: 0000000120,0000000220,0000000320
    //output: 0000000121,0000000221,0000000321`



#### Example 12: Reset Prefix and Suffix (Both )ID yearly

$prefix='INV'; $prefix='Pro';

    $id = UniqueIdGenerator::generate(['table' => 'invoices', 'length' => 13, 'prefix' =>$prefix,'suffix' =>date('y'),'reset_on_change'=>'both']]);
    //output: INV0000000120,INV0000000220,INV0000000320 
    //output: Pro0000000121,Pro0000000221,Pro0000000321
