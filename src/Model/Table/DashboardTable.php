<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;

class DashboardTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);
        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    //query for fetching cities from city column in users table
    public function fetchCity() {
        $query = $this->find();
        $query->select(['city']);
        $query->distinct(['city']);
        $query->where(['city <>' => '']);
//                if(!empty($year)){
//                $query->where(['YEAR(complaint_id_genrate_date)' => $year]);
//                }
        $query->order(['city']);
        $city = $query->toArray();
        return $city;
    }

    //query for counting total pending logistics
    public function countPendingLogistics($arr) {
        $query = $this->find();
        $query->select(['count' => $query->func()->count('id')]);
        $query->where(['ob_status' => 1]);
        $query->where(['id NOT IN' => $arr]);
        $total = $query->toArray();
        $result = $total[0]->count;
        return $result;
    }
    
    //query to get onboard count data datewise of one year
    public function CountBoardBasedOnDate($yesterday, $previous12month) {
        $query = $this->find();
        $row = $query->select(['date' => 'DATE(created)', 'value' => $query->func()->count('*')])
                ->where(['ob_status' => 1])
                ->where(['DATE(created) <=' => $yesterday, 'DATE(created) >=' => $previous12month])
                ->group('DATE(created)')
                ->order('DATE(created)');
        $uData = [];
        foreach ($row as $r) {
            $uData[] = $r->toArray();
        }
        if (!empty($uData)) {
            $uData = json_encode($uData);
        }
        return $uData;
    }
    
    //qyery to get Active/confirmed/rejected and inactive count data datewise of one year
    public function countConfirmationBasedOnDate($yesterday, $previous12month) {
        $query = $this->find();
        $row = $query->select(['date' => 'DATE(created)', 'value' => $query->func()->count('*'), 'status'])
                        ->where(['ob_status' => 1])
                        ->where(['DATE(created) <=' => $yesterday, 'DATE(created) >=' => $previous12month])
                        ->group('DATE(created)')
                        ->order('DATE(created)')->toArray();
        $uData = [];
        foreach ($row as $r) {
            $tmp = [];
            $tmp['date'] = $r['date'];
            $tmp['value1'] = "";
            $tmp['value2'] = "";
            $tmp['value3'] = "";
            $tmp['value4'] = "";
            if($r['status'] == 1){
                $tmp['value1'] = $r['value'];
            }
            if($r['status'] == 2){
                $tmp['value2'] = $r['value'];
            }
            if($r['status'] == 3){
                $tmp['value3'] = $r['value'];
            }
            if($r['status'] == 0){
                $tmp['value4'] = $r['value'];
            }
            $uData[]=$tmp;
        }
        
        if(!empty($uData)){
            $uData = json_encode($uData);
        }
        return $uData;
    }
    
    //query to get board count data datewise based on search
     public function CountBoardBasedOnSearch($fromdate,$todate,$business_unit = '', 
             $department = '', $sub_department = '', $city = ''){
        $query = $this->find();
        $row = $query->select(['date' => 'DATE(created)', 'value' => $query->func()->count('*')])
                ->where(['ob_status' => 1]);
                    if (!empty($business_unit)) {
                        $row->where(['businees_unit' => $business_unit]);
                    }
                    if (!empty($department)) {
                        $row->where(['department' => $department]);
                    }
                    if (!empty($sub_department)) {
                        $row->where(['sub_department' => $sub_department]);
                    }
                    if (!empty($city)) {
                        $row->where(['city' => $city]);
                    }
            $row->where(['DATE(created) <=' => $fromdate, 'DATE(created) >=' => $todate])
                ->group('DATE(created)')
                ->order('DATE(created)');
        $uData = [];
        foreach ($row as $r) {
            $uData[] = $r->toArray();
        }
        if (!empty($uData)) {
            $uData = json_encode($uData);
        }else{
            $uData[] = ["date"=>$fromdate,"value"=>''];
            $uData = json_encode($uData);
        }
        return $uData;
    }
    
    //query to get Active/confirmed/rejected and inactive count data datewise  based on search
    public function countConfirmationBasedOnSearch($fromdate,$todate,$business_unit = '',
             $department = '', $sub_department = '', $city = '') {
        $query = $this->find();
        $row = $query->select(['date' => 'DATE(created)', 'value' => $query->func()->count('*'), 'status'])
                        ->where(['ob_status' => 1]);
                            if (!empty($business_unit)) {
                                $row->where(['businees_unit' => $business_unit]);
                            }
                            if (!empty($department)) {
                                $row->where(['department' => $department]);
                            }
                            if (!empty($sub_department)) {
                                $row->where(['sub_department' => $sub_department]);
                            }
                            if (!empty($city)) {
                                $row->where(['city' => $city]);
                            }
            $row->where(['DATE(created) <=' => $fromdate, 'DATE(created) >=' => $todate])
                        ->group('DATE(created)')
                        ->order('DATE(created)')->toArray();
        $uData = [];
        foreach ($row as $r) {
            $tmp = [];
            $tmp['date'] = $r['date'];
            $tmp['value1'] = "";
            $tmp['value2'] = "";
            $tmp['value3'] = "";
            $tmp['value4'] = "";
            if($r['status'] == 1){
                $tmp['value1'] = $r['value'];
            }
            if($r['status'] == 2){
                $tmp['value2'] = $r['value'];
            }
            if($r['status'] == 3){
                $tmp['value3'] = $r['value'];
            }
            if($r['status'] == 0){
                $tmp['value4'] = $r['value'];
            }
            $uData[]=$tmp;
        }
        if(!empty($uData)){
            $uData = json_encode($uData);
        }else{
            $uData[] = ["date"=>$fromdate,"value1"=>'',"value2"=>'',"value3"=>'',"value4"=>''];
            $uData = json_encode($uData);
        }
        return $uData;
    }
    
    
    /*
    @ Query starts here for getting counting of records for plotting graph
    */
    
    public function getOnBoardCountBasedOnDate($fromDate='',$toDate='',$business_units='',
            $department='',$sub_department='',$city=''){
        $query = $this->find();
        $row   = $query->select(['month' => 'MONTH(created)', 'value' => $query->func()->count('*')])
                ->where(['ob_status' => 1, 'DATE(created) <>' => '0000-00-00 00:00:00']);
                            if(!empty($fromDate) && !empty($toDate)){
                                $row->where(['DATE(created) <=' => $fromDate, 'DATE(created) >=' => $toDate]);
                            }
                            if (!empty($business_unit)) {
                                $row->where(['businees_unit' => $business_unit]);
                            }
                            if (!empty($department)) {
                                $row->where(['department' => $department]);
                            }
                            if (!empty($sub_department)) {
                                $row->where(['sub_department' => $sub_department]);
                            }
                            if (!empty($city)) {
                                $row->where(['city' => $city]);
                            }
            $row->group(['MONTH(created)'])
                ->order(['MONTH(created)'])->toArray();
       $uData = [];
       foreach ($row as $p){
          $tmp = $p['month'] + 3; 
          $monthName = date('M', strtotime("$tmp month"));
          $value = $p['value'];
          $uData[] = ['label' => $monthName, 'value' => $value];
       }
       return $uData;
    }
    
    public function getMonthBasedOnDate($fromDate='',$toDate=''){
        $query = $this->find()->select(['month' => 'Month(created)'])
                ->where(['ob_status' => 1, 'DATE(created) <>' => '0000-00-00 00:00:00'])
                ->where(['DATE(created) <=' => $fromDate, 'DATE(created) >=' => $toDate])
                ->group(['MONTH(created)'])
                ->order(['MONTH(created)']);
        $m = [];
        foreach($query as $r){
            $m[] = $r->toArray();
        }
        return $m;
    }
    
    public function getDate($fromDate='',$toDate=''){
        $query = $this->find()->select(['date' => 'DATE(created)'])
                ->where(['ob_status' => 1, 'DATE(created) <>' => '0000-00-00 00:00:00'])
                ->where(['DATE(created) <=' => $fromDate, 'DATE(created) >=' => $toDate])
                ->group(['DATE(created)'])
                ->order(['DATE(created)']);
        $m = [];
        foreach($query as $r){
            //pr($r);die;
            $m[] = $r->toArray();
        }
        
        return $m;
    }
    
    public function getConfirmedCountBasedOnDate($status='',$arr='',$business_units='',
                        $department='',$sub_department='',$city=''){
        $query = $this->find();
        $row   = $query->select(['value' =>$query->func()->count('*')]);
                       if(!empty($arr)){
                           $row->where(['MONTH(created)' => $arr]);
                       }
                       if (!empty($business_unit)) {
                                $row->where(['businees_unit' => $business_unit]);
                            }
                      if (!empty($department)) {
                                $row->where(['department' => $department]);
                            }
                      if (!empty($sub_department)) {
                                $row->where(['sub_department' => $sub_department]);
                            }
                      if (!empty($city)) {
                                $row->where(['city' => $city]);
                            }
                           $row->where(['status' => $status]);
                       $row->where(['ob_status' => 1, 'DATE(created) <>' => '0000-00-00 00:00:00'])->toArray();
        foreach ($row as $r){
            $p = $r['value'];
        }   
        return $p;
    }
    
    public function getOnBoardSevenDays($fromDate='',$toDate='',$business_units='',$status='',
            $department='',$sub_department='',$city=''){
        $query = $this->find();
        $row   = $query->select(['label' => 'DATE(created)', 'value' => $query->func()->count('*')])
                      ->where(['ob_status' => 1, 'DATE(created) <>' => '0000-00-00 00:00:00'])
                      ->where(['DATE(created) <=' => $fromDate, 'DATE(created) >=' => $toDate]);
                      if (!empty($business_unit)) {
                                $row->where(['businees_unit' => $business_unit]);
                            }
                      if (!empty($department)) {
                                $row->where(['department' => $department]);
                            }
                      if (!empty($sub_department)) {
                                $row->where(['sub_department' => $sub_department]);
                            }
                      if (!empty($city)) {
                                $row->where(['city' => $city]);
                            }
                      $row->group('DATE(created)');
                      $row->order(['DATE(created)']);
            $uData = [];          
            foreach($row as $r){
               $uData[] = $r->toArray();
            }   
            
           if(!empty($uData)){
               $uData = json_encode($uData);
           }else{
               $uData = ['label' => '', 'value' => ''];
               $uData = json_encode($uData);
           }
           echo $uData;
    }
    
    public function getConfirmedSevenDays($date='',$status='',$business_units='',$department='',
            $sub_department='',$city=''){
        $query = $this->find();
        $row   = $query->select(['value' => $query->func()->count('*')])
                      ->where(['ob_status' => 1, 'DATE(created) <>' => '0000-00-00 00:00:00'])
                      ->where(['DATE(created)' => $date]);
                      if (!empty($business_unit)) {
                                $row->where(['businees_unit' => $business_unit]);
                            }
                      if (!empty($department)) {
                                $row->where(['department' => $department]);
                            }
                      if (!empty($sub_department)) {
                                $row->where(['sub_department' => $sub_department]);
                            }
                      if (!empty($city)) {
                                $row->where(['city' => $city]);
                            }
                      $row->where(['status' => $status]);
//                      echo $row;
//                      echo $date;
//                      echo $status;
                foreach ($row as $r){
                    $a = $r->toArray();
                }    
                return $a['value'];
    }
    
//    public function getMonthName($monthName){
//        $month = '';
//                switch($monthName){
//                    case '1':
//                        $month = 'Jan';
//                        break;
//                    case '2':
//                        $month = 'Feb';
//                        break;
//                    case '3':
//                        $month = 'Mar';
//                        break;
//                    case '4':
//                        $month = 'Apr';
//                        break;
//                    case '5':
//                        $month = 'May';  
//                        break;
//                    case '6':
//                        $month = 'Jun';   
//                        break;
//                    case '7':
//                        $month = 'Jul'; 
//                        break;
//                    case '8':
//                        $month = 'Aug';
//                        break;
//                    case '9':
//                        $month = 'Sep'; 
//                        break;
//                    case '10':
//                        $month = 'Oct'; 
//                        break;
//                    case '11':
//                        $month = 'Nov'; 
//                        break;
//                    case '12':
//                        $month = 'Dec'; 
//                        break;
//                }
//        return $month;
//    }
    
   
}
