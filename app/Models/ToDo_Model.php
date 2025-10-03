<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ToDo_Model extends Model
{
    use HasFactory;
    protected $table = 'todo_list';
    protected $fillable = ['title', 'description', 'completed'];
}
