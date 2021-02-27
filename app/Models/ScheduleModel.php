<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class ScheduleModel extends Model
{
    protected $table = 'schedule';
    protected $primaryKey = 'id';
    protected $allowedFields = ['day_off_id','user_id'];
}