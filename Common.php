<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Common extends Eloquent {

    public static function InttoNumber($f) {

        $base = floor($f);
        if ($base) {
            $out = $base . ' ';
            $f = $f - $base;
        }
        if ($f != 0) {
            $d = 1;
            while (fmod($f, 1) != 0.0) {
                $f *= 2;
                $d *= 2;
            }
            $n = sprintf('%.0f', $f);
            $d = sprintf('%.0f', $d);
            $out .= $n . '/' . $d;
        }
        return $out;
    }
  public static function cal_days_in_month($calendar, $month, $year) {
        return date('t', mktime(0, 0, 0, $month, 1, $year));
    }

    public static function departmentName($emp_id) {
        $db2 = DB::connection('companyDB');

        $query = $db2->select($db2->raw("SELECT dep.* FROM hr_emp_job_info info 
            JOIN hr_department dep ON info.`fkDepartment_id`= dep.id 
            WHERE info.fkEmp_id= ".$emp_id." ORDER BY info.id DESC limit 1"));

        $result = array();
        $res = $query;
        if (count($res) > 0) {
            $id = $res[0]->id;
            $dep = $res[0]->department;
            $result[0] = $id;
            $result[1]=$dep;
        }
        return $result ? $result : '';
    }
    
    public static function supervisorlist() {
          $db2 = DB::connection('companyDB');
          $query = $db2->select($db2->raw("SELECT * FROM hr_emp_job_info info 
            JOIN hr_emp_info emp ON info.`fkReport_id`= emp.id 
            GROUP BY info.fkReport_id DESC "));
            $list= array();
          foreach($query as $res){
              $list[$res->id]= $res->employee_id.' - '.$res->first_name.' '.$res->last_name;
          }
          return $list;
        
    }
    
    public static function departmentlist() {
        
         $db2 = DB::connection('companyDB');
          $query = $db2->select($db2->raw("SELECT * FROM hr_department"));
            $list= array();
          foreach($query as $res){
              $list[$res->id]= $res->department;
          }
          return $list;
    }
    public static function CalendarHalfdaycount($id) {
         
        $db2 = DB::connection('companyDB');
        $query = $db2->table('hr_calendar_config')->where('id', '=', $id)->first();
      
        $count = 0;
        if ($query->mon == 10) {
            $count += 1;
        }if ($query->tue == 10) {
            $count += 1;
        }if ($query->wed == 10) {
            $count += 1;
        }if ($query->thurs == 10) {
            $count += 1;
        }if ($query->fri == 10) {
            $count += 1;
        }if ($query->sat == 10) {
            $count += 1;
        }if ($query->sun == 10) {
            $count += 1;
        }

        return $count;
    }

    public static function totalworkingdays() {
        
        $db2 = DB::connection('companyDB');
        $query = $db2->table('hr_calendar_config')->ORDERBY('id', 'DESC')->first();

         $count = 0;
       if($query){
  if ($query->mon != 9 ) {
            $count += 1;
        }if ($query->tue != 9) {
            $count += 1;
        }if ($query->wed != 9) {
            $count += 1;
        }if ($query->thurs != 9) {
            $count += 1;
        }if ($query->fri != 9) {
            $count += 1;
        }if ($query->sat != 9) {
            $count += 1;
        }if ($query->sun != 9) {
            $count += 1;
        }
}
       return $count;
    }


  public static function rosterstatus($id) {
        $data = [
            Config::get('constants._ROSTER_DRAFT') => 'Draft',
            Config::get('constants._ROSTER_SCHEDULE') => 'Scheduled',
            Config::get('constants._ROSTER_CLOCKED') => 'Clocked',
  Config::get('constants._ROSTER_PENDING_APPROVED') => 'Pending For Approval',
  Config::get('constants._ROSTER_APPROVED') => 'Approved',
        ];
        return $id ? $data[$id] : '';
    }
	public static function income($emp_id) {
          $db2 = DB::connection('companyDB');
           $income = $db2->select($db2->raw("select t2.emp_id from hr_emp_salary as t1 inner join hr_ir8a_files as t2 on t2.emp_id = t1.fkEmpId where t2.emp_id = t1.fkEmpId and t2.year_of = YEAR(t1.from_date)"));
         return  $income ?  $income : '';
     }
	 
	  public static function get_monthDays(){
        $temp =[];
        for($i=1; $i<32;$i++){
            $temp[$i]=$i;
        }
        return $temp;
    }

   public static function Totalempscheduled($id) {

        $db2 = DB::connection('companyDB');
        $query = $db2->table('hr_roster_attendance')->where('roster_id', '=', $id)->count('emp_id');
        return $query;
    }

    public static function Totalempactual($id) {

        $db2 = DB::connection('companyDB');
        $query = $db2->table('hr_roster_attendance')->where('roster_id', '=', $id)->where('actual_time_in','<>',0)->groupby('emp_id')->count('emp_id');
        return $query;
    }
    public static function getmonthlyDays() {

        $temp = [];
        for ($i = 1; $i <= 31; $i++) {
            $temp[] = $i;
        }
        return $temp;
    }
   public static function get_fornightlist() {
        $temp = [];
        for ($i = 1; $i <= 16; $i++) {
            $temp[] = $i;
        }
       return $temp;
    }
    public static function defaultschedule() {
        $schedule  = CompanySettings::select('schedule_id')->first();
      return ($schedule['schedule_id'])?($schedule['schedule_id']):'';
    }
 public static function is_Ir8aPDF_exists($for_year, $emp_id) {
        $db2 = DB::connection('companyDB');
        $ir8a_record = $db2->table('hr_ir8a_files')
                ->select()
                ->where('year_of', '=', $for_year)
                ->where('emp_id', '=', $emp_id)
                ->get();

        if ($ir8a_record && count($ir8a_record) > 0) {
            return true;
        }
        return false;
    }
    public static function getIr8aEmpSalarayList($cpy_id, $emp_id, $from_date) {
        /* To get emp data */
        $db2 = DB::connection('companyDB');
        $resultList = $db2->table('hr_emp_salary as t1')
                ->join('hr_emp_info as t2', 't2.id', '=', 't1.fkEmpId')
                ->select(DB::raw('SUM(t1.gross) as gross_pay,SUM(t1.comm) as commission_pay,SUM(t1.tot_cpf_ee) as cpf,SUM(t1.bonus) as bonus, SUM(t1.fund) as fund, t1.fund_mode
                        ,t2.id as empId,t2.first_name,t2.employee_id,t2.nric_fin_no,t1.from_date,t1.bonus_desc'));
        $resultList = $resultList->where('t1.fkEmpId', $emp_id);

        $salary = $resultList->whereRaw('YEAR(t1.from_date) = ' . $from_date . '')->where('t1.status', 1)->groupBy('t1.fkEmpId')->where('t1.fkEmpId', $emp_id)->first();

        return $salary ? $salary : FALSE;
    }

    public static function getIr8aEmpBonusDesc($cpy_id, $emp_id, $from_date) {
        $db2 = DB::connection('companyDB');
        $bonusdesc = $db2->table('hr_emp_salary')
                ->select('from_date', 'fkEmpId', 'bonus_desc')
                ->where('bonus', '!=', 0);
        $bonusdesc = $bonusdesc->where('fkEmpId', $emp_id);
        $bonusdesc = $bonusdesc->whereRaw('YEAR(from_date) = ' . $from_date . '')->where('status', 1)->first();
        return $bonusdesc ? $bonusdesc : FALSE;
    }

    public static function getIr8aEmpInfo($emp_id) {
        $db2 = DB::connection('companyDB');
        $result = $db2->table('hr_emp_info')->where('id', $emp_id)->first();

        return $result ? $result : FALSE;
    }

    public static function getIr8aEmpRole($cpy_id, $emp_id) {
        $result = DB::table('hr_login_credentials')->select('account_type')->where('fkUserId', '=', $emp_id)->where('fkCompany_id', '=', $cpy_id)->first();

        return $result ? $result : FALSE;
    }

         public static function getIr8aMBF_tot($from_date, $emp_id) {
        $db2 = DB::connection('companyDB');
        $salary_data = $db2->table('hr_emp_salary')
                ->select(DB::raw('fkEmpId,fund, fund_mode'))
                ->whereRaw('YEAR(from_date) = ' . $from_date . '')
                ->where('fund_mode', '=', 2)
                ->where('fkEmpId', $emp_id)
                ->get();
//print_r($salary_data);
        if (!$salary_data) {
            return false;
        }
        $mbf = 0;
        foreach ($salary_data as $data) {

            if ($data->fund == '2.00') {
                $mbf = $mbf + '1.00';
            }
            if ($data->fund == '3.50') {
                $mbf = $mbf + '2.25';
            }
            if ($data->fund == '5.00') {
                $mbf = $mbf + '3.60';
            }
            if ($data->fund == '12.50') {
                $mbf = $mbf + '8.00';
            }
            if ($data->fund == '16.00') {
                $mbf = $mbf + '10.75';
            }
        }
        return number_format($mbf, 2);
    }

    public static function getIr8aYCF_tot($from_date, $emp_id) {
       $db2 = DB::connection('companyDB');
        $salary_data = $db2->table('hr_emp_salary')
                ->select(DB::raw('fkEmpId,fund, fund_mode'))
                //->whereRaw('YEAR(from_date) = ' . $from_date . '')
                ->where('fund_mode', '=', 2)
                ->where('fkEmpId', $emp_id)
                ->get();
//print_r($salary_data);
        if (!$salary_data) {
            return false;
        }
        $ycf = 0;
        foreach ($salary_data as $data) {

            if ($data->fund == '2.00') {
                $ycf = $ycf + '1.00';
            }
            if ($data->fund == '3.50') {
                $ycf = $ycf + '1.25';
            }
            if ($data->fund == '5.00') {
                $ycf = $ycf + '1.40';
            }
            if ($data->fund == '12.50') {
                $ycf = $ycf + '4.50';
            }
            if ($data->fund == '16.00') {
                $ycf = $ycf + '5.25';
            }
        }
        return number_format($ycf, 2);
    }
 public static function getjoiningdate($emp_id, $date) {
        $db2 = DB::connection('companyDB');
        $query = $db2->table('hr_emp_job_status')
                        ->select('hire_date')
                        ->where('fkEmp_id', '=', $emp_id)->where('hire_date', '<=', date('Y-m-d', strtotime($date)))->orderby('hire_date', 'DESC')->first();

        return ($query)?date('d-m-Y',strtotime($query->hire_date)) : '';
    }

    public static function getenddate($emp_id, $date) {
        $db2 = DB::connection('companyDB');
        $query = $db2->table('hr_emp_job_status')
                        ->select('end_date')
                        ->where('fkEmp_id', '=', $emp_id)->where('hire_date', '<=', date('Y-m-d', strtotime($date)))->orderby('hire_date', 'DESC')->first();

        return ($query)?date('d-m-Y',strtotime($query->end_date)):'-';
    }

    public static function CalendarOffdaycount($id) {
        $db2 = DB::connection('companyDB');
        $query = $db2->table('hr_calendar_config')->where('id', '=', $id)->first();

        $count = 0;
		if($query){
        if ($query->mon == 9) {
            $count += 1;
        }if ($query->tue == 9) {
            $count += 1;
        }if ($query->wed == 9) {
            $count += 1;
        }if ($query->thurs == 9) {
            $count += 1;
        }if ($query->fri == 9) {
            $count += 1;
        }if ($query->sat == 9) {
            $count += 1;
        }if ($query->sun == 9) {
            $count += 1;
        }
		}

        return $count;
    }
  public static function getnationality($emp_id) {
 $db2 = DB::connection('companyDB');
        $nationality = $db2->table('hr_nationality as na')
                        ->join('hr_emp_info as info', 'info.nationality', "=", 'na.id')->select('nationality_name')->where('info.id', '=', $emp_id)->first();
        return ($nationality) ? $nationality->nationality_name : '';
    }

     public static function getNextLevel($emp_id) {
        $db2 = DB::connection('companyDB');
        $level = $db2->table('hr_emp_job_info as job')
                        ->join('hr_emp_info as info', 'info.id', "=", 'job.fkEmp_id')
                       // ->select('info.id')
                        ->where('info.local_del', '=', 0)
			->where('job.is_delete','=',1)
                        ->where('job.fkEmp_id', '!=', $emp_id)
                        ->where('job.fkReport_id', '=', $emp_id)->get();
    $emp_details = '';
        $emp_ids = [];
        if ($level) {
            foreach ($level as $l) {
                $data = Common::getLevel($l->id, $emp_id);
                if ($data) {
                    $emp_ids[] = $l->id;
                }
            }
        }

        if (!empty($emp_ids)) {
            $emp_details = $db2->table('hr_emp_job_info as job')
                            ->join('hr_emp_info as info', 'info.id', "=", 'job.fkEmp_id')
                            ->select('info.*', 'job.fkDivision_id', 'job.fkDepartment_id')
                            ->whereIn('info.id', $emp_ids)
                            ->where('job.fkReport_id', '=', $emp_id)->where('job.is_delete','=',1)->where('info.local_del', '=', 0)->get();
        }

        return ($emp_details) ? $emp_details : '';
    }

    public static function getallLevel($emp_id, $limit) {
        $db2 = DB::connection('companyDB');
        $level = $db2->table('hr_emp_job_info as job')
                        ->join('hr_emp_info as info', 'info.id', "=", 'job.fkEmp_id')
                        ->select('info.id')
                        ->where('info.local_del', '=', 0)->where('job.is_delete','=',1)
                        ->where('job.fkEmp_id', '!=', $emp_id)
                        ->where('job.fkReport_id', '=', $emp_id)->get();
        $emp_details = '';
        $emp_ids = [];
        if ($level) {
            foreach ($level as $l) {
                $data = Common::getLevel($l->id, $emp_id);
                if ($data) {
                    $emp_ids[] = $l->id;
                }
            }
        }
        if (!empty($emp_ids)) {
            $emp_details = $db2->table('hr_emp_job_info as job')
                            ->join('hr_emp_info as info', 'info.id', "=", 'job.fkEmp_id')
                            ->select('info.*', 'job.fkDivision_id', 'job.fkDepartment_id')
                            ->whereIn('info.id', $emp_ids)
                            ->where('job.fkReport_id', '=', $emp_id)->where('job.is_delete','=',1)->where('info.local_del', '=', 0)->get();
        }
        if ($limit) {
            $result = $limit;
        } else {
            $result = '';
        }
        if ($emp_details) {
            $result .= "<ul>";
            foreach ($emp_details as $l) {

                $result .= '<li class="submenus aa">'
                        . '<a  class="menu" href="javascript:void(0)">' .$l->employee_id.'-'.$l->first_name . ' <br>
                                                                        <span> ' . Common::NameDivision($l->fkDivision_id) . '</span><br>
                                                                        <span>' . Common::NameDepartment($l->fkDepartment_id) . '</span></a>';

                return Common::getallLevel($l->id, $result);
                $result .= '</li>';
            }
            $result .= "</ul>";
        }
        return $result;
    }

    public static function getLevel($emp_id, $report_id) {

        $db2 = DB::connection('companyDB');
        $data = $db2->table('hr_emp_job_info')
                        ->where('fkEmp_id', '=', $emp_id)->where('is_delete', '=', 1)->orderby('id', 'desc')->first();
        if ($data) {
            if ($data->fkReport_id == $report_id) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function NameDivision($id) {
        $db2 = DB::connection('companyDB');
        $divi = $db2->table('hr_division')
                        ->select('div_name')
                        ->where('id', '=', $id)->first();
        return $divi ? $divi->div_name : '';
    }

    public static function NameDepartment($id) {
        $db2 = DB::connection('companyDB');
        $divi = $db2->table('hr_department')
                        ->select('department')
                        ->where('id', '=', $id)->first();
        return $divi ? $divi->department : '';
    }
      public static function getMultiapprove($multi_id,$id,$jid) {
          $db2 = DB::connection('companyDB');
         $approve = $db2->table('hr_expense_approve')
                 ->where('job_id', '=', $jid)->where('emp_id', '=', $id)
                 ->where('multi_approve_id','=',$multi_id)->orderBy('sort_order')->first();
         return $approve?$approve:false;
    }
  public static function getPayrollIns($ins_name, $emp_id, $from_date, $to_date) {
        $db2 = DB::connection('companyDB');
        $ins_name = strtolower($ins_name);
        if ($ins_name == 'commission') {
            $ins_name = 'comm';
        } if ($ins_name == 'reimbursement') {
            $ins_name = 'reimbure';
        }
        $query = $db2->table('hr_emp_salary')->select($ins_name)->where('fkEmpId', '=', $emp_id)->where('from_date', '=', $from_date)
                        ->where('to_date', '=', $to_date)->first();

        return $query ? $query->$ins_name : false;
    }
  public static function getOvertimePayroll($from_date, $to_date, $emp_id) {
        $db2 = DB::connection('companyDB');
        $query = $db2->table('hr_overtime_computation')
                        ->whereRaw("from_date >= '" . date('Y-m-d', strtotime($from_date)) . "'")
                        ->whereRaw("to_date <= '" . date('Y-m-d', strtotime($to_date)) . "'")
                        ->where('emp_id', '=', $emp_id)->get();

        return $query ? $query : '';
    }
	public static function factorRating($fac_id) {
        $db2 = DB::connection('companyDB');
        $rating_details = $query = $db2->table('hr_performance_rating')->where('per_id', $fac_id)->select('rating')->get();

        return $rating_details ? $rating_details : false;
    }

    public static function factoroverRating($fac_id) {
        $db2 = DB::connection('companyDB');
        $rating_details = $query = $db2->table('hr_policy_rating')->where('factor_id', $fac_id)->select('rating')->get();

        return $rating_details ? $rating_details : false;
    }
	public static function pmRating($rating_id) {
        $db2 = DB::connection('companyDB');
        $rating_details = $query = $db2->table('hr_overall_performance_rating')->where('id',$rating_id)->select('rating')->first();

        return $rating_details ? $rating_details : false;
    }
    
     public static function pmoverallRating($rating_id) {
        $db2 = DB::connection('companyDB');
        $rating_details = $query = $db2->table('hr_overall_performance_rating')->where('id',$rating_id)->select('rating')->first();

        return $rating_details ? $rating_details : false;
    }
  public static function IsEnablemultipleapproval($emp_id) {
        $cmpID = Session::has('proxy_cpy_id') ? Session::get('proxy_cpy_id') : Session::get('cpy_id');
        $ml_settings = DB::table('hr_login_credentials')->select('muliple_option', 'ml_settings')->where('fkCompany_id', $cmpID)->where('fkUserId', $emp_id)->first();
        if (($ml_settings->muliple_option == 1) && ($ml_settings->ml_settings)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getMultiApproverLevel($module_id, $module) {
        $db2 = DB::connection('companyDB');
        $multi_approve = $db2->table('hr_multi_approver')->where('module_id', '=', $module_id)
                        ->where('approve_module', '=', $module)->first();
        if ($multi_approve) {
            if ($multi_approve->total_level == $multi_approve->approved_level) {
                return "approved";
            } else {
                return "Pending For " . $multi_approve->pending_level . " Level Approval";
            }
        }
    }

    public static function getMultiApproverPermission($module_id, $emp_id, $module) {
        $db2 = DB::connection('companyDB');
        $multi_approve = $db2->table('hr_multi_approver')->where('module_id', '=', $module_id)
                        ->where('approve_module', '=', $module)->first();

        if (($multi_approve) && ($multi_approve->total_level != $multi_approve->approved_level)) {
            $level = $db2->table('hr_expense_approve')->where('job_id', '=', $multi_approve->job_id)
                            ->where('emp_id', '=', $emp_id)
                            ->where('approve_module', '=', $module)->orderby('id', 'asc')->get();

            if ($multi_approve->approved_level) {
                return $level[$multi_approve->approved_level]->level_id;
            } else {
                return $level[0]->level_id;
            }
        } else {
            return false;
        }
    }
}

