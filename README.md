<h1 align="center">Laravel Unique ID/Code Generator ( Prefix or Suffix or Both or Only Id/Code Without Prefix/Suffix )</h1>

<p align="center">Generate custom ID or Code (Postfix or Suffix Or Both) in laravel framework</p>

# Installation

`composer require sirajcse/laravel-unique-id-generator` 

How to use it?
You can use it in your controller code like as a helper or inside your model by defining a boot method.

Unique ID/Code Generatore
Like 

`Inv-000001/12/21

'table' => 'invoices'

'field'=>'invoice_id' [Default 'id'] [Optional]

'length' => 12

'prefix'=>'Inv-' [Default ''] [Optional]

'suffix'=>date('/m/y') [Default ''] [Optional]
 
'reset_on_change'=>false[ Default false] [Optional]

uniqueId=000001`


**Default field** 
Default field value id; [like 'field'=>'id']
If need 'code' field in a table;
'field'=>'code'

**Prefix Or Suffix**
Default Value Prefix=>'' or Suffix=>'';

**Reset On Change**
If you want to reset value at the beginning of every prefix or suffix or both changes then set it value;
[reset_on_change has 4 option prefix,suffix,both,false]
Default Value reset_on_change= false;

### Example with controller

Import ID generator for Prefix


use sirajcse\UniqueIdGenerator\UniqueIdGenerator;

_**For Prefix**_

public function store(Request $request){

	$id = UniqueIdGenerator::generate(['table' => 'todos', 'length' => 6, 'prefix' => date('y')]);
	$todo = new Todo();
	$todo->id = $id;
	$todo->title = $request->get('title');
	$todo->save();
	
}

_**For Suffix**_

public function store(Request $request){

	$id = UniqueIdGenerator::generate(['table' => 'todos', 'length' => 6, 'suffix' => date('y')]);
	$todo = new Todo();
	$todo->id = $id;
	$todo->title = $request->get('title');
	$todo->save();
	
}

_**For Both Prefix and Suffix**_

public function store(Request $request){

	$id = UniqueIdGenerator::generate(['table' => 'todos', 'length' => 10,'prefix' => 'Inv-', 'suffix' => date('y')]);
	$todo = new Todo();
	$todo->id = $id;
	$todo->title = $request->get('title');
	$todo->save();
	
}

**N.B: If you generate ID to the table id field then you must have to set the id field as fillable and public $incrementing = false; inside your model.**

 

Example with the model

In your model add a boot method. The ID will automatically generate when a new record will be added.

associative array for 'prefix', 'suffix' add if needed 

public static function boot()
{
    parent::boot();
    self::creating(function ($model) {
        $model->uuid = UniqueIdGenerator::generate(['table' => $this->table, 'length' => 10,'prefix' =>'Inv-', 'suffix' =>date('y')]);
    });
}
 

Parameters

You must pass an associative array into generate function with table, length and prefix key.

table = Your table name.

field = Optional. By default, it works on the id field. You can set other field names also.

length = Your ID length

prefix = Define your prefix. It can be a year prefix, month or any custom letter.

reset_on_prefix_change = Optional, default false. If you want to reset id from 1 on prefix change then set it true.

 

Example: 01

`$config = [
    'table' => 'todos',
    'length' => 6,
    'prefix' => date('y')
    'suffix' => ''
];`

`// now use it
$id = UniqueIdGenerator::generate($config);
`
### _// use within single line code_

**Example 01: Only unique id/code with out Prefix, Suffix**

`$id = UniqueIdGenerator::generate(['table' => 'todos', 'length' => 6]);
// output: 000001, 0000002`
 

**Example 02: INV-000001 for prefix string. Your field must be varchar.**

`$id = UniqueIdGenerator::generate(['table' => 'invoices', 'length' => 10, 'prefix' =>'INV-']);
//output: INV-000001 ,INV-000002`

**Example 03: 000001/2021 for suffix string. Your field must be varchar.**

`$id = UniqueIdGenerator::generate(['table' => 'invoices', 'length' => 10, 'suffix' =>date('/Y')]);
//output: 00001/2021, 00002/2021
`

**Example 04: INV-000001/2021 for prefix string. Your field must be varchar.**

`$id = UniqueIdGenerator::generate(['table' => 'invoices', 'length' => 14,'prefix' =>'INV-', 'suffix' =>date('/Y')]);
//output: INV-00001/2021, INV-00002/2021`
 

**Example 05: By default, this package works on the ID field. You can set another field to generate an ID. Make sure your **selected field must be unique** and also **proper data type**.**

`$id = UniqueIdGenerator::generate(['table' => 'products','field'=>'pid', 'length' => 6, 'prefix' =>date('P')]);
//output: P00001
 `

**_Example 06: By default, this package won't reset your ID when you change your prefix of ID. 
If you want to reset your ID from 1 on every prefix changes then pass reset_on_change => 'prefix'
If you want to reset your ID from 1 on every suffix changes then pass reset_on_change => 'suffix'
If you want to reset your ID from 1 on every prefix and suffix (both) changes then pass reset_on_change => 'both'**_

**Example 07:
**Reset Prefix ID yearly****

`$id = UniqueIdGenerator::generate(['table' => 'invoices', 'length' => 10, 'prefix' =>date('y'), 'reset_on_change'=>'prefix']);
//output: 2000000001,2000000002,2000000003
//output: 2100000001,2100000002,2100000003`

**Example 08:
Reset ID monthly**

`$id = UniqueIdGenerator::generate(['table' => 'invoices', 'length' => 10, 'prefix' =>date('ym'),, 'reset_on_change'=>'prefix']]);
//output: 1912000001,1912000002,1912000003
//output: 2001000001,2001000002,2001000003`

**Example 09:
Or any prefix change**

`$id = UniqueIdGenerator::generate(['table' => 'products', 'length' => 6, 'prefix' => $prefix, 'reset_on_change'=>'prefix']]);
//output: A00001,A00002,B00001,B00002`

**Example 10:
Reset Suffix ID yearly** 

`$id = UniqueIdGenerator::generate(['table' => 'invoices', 'length' => 10, 'suffix' =>date('y'),'reset_on_change'=>'suffix']]);
//output: 0000000120,0000000220,0000000320
//output: 0000000121,0000000221,0000000321`

**Example 11:
Reset Prefix and Suffix (Both )ID yearly** 

**$prefix='INV';
$prefix='Pro';**

Example 12:
`$id = UniqueIdGenerator::generate(['table' => 'invoices', 'length' => 13, 'prefix' =>$prefix,'suffix' =>date('y'),'reset_on_change'=>'both']]);
//output: INV0000000120,INV0000000220,INV0000000320
//output: Pro0000000121,Pro0000000221,Pro0000000321`
