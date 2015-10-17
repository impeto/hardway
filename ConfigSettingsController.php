<?php

class ConfigSettingsController extends BaseController {
    /*
     * Intial setup
     */

    public function __construct() {
        //$this->table_name = "hr_login_credentials";
        if (Session::has('log_id')) {
            DB2::dbConnection();
            $this->db2 = DB::connection('companyDB');
        } else {
            $this->beforeFilter(function() {
                return Redirect::to('login');
            });
        }
            
            if (!class_exists('S3'))require_once('s3libs/S3.php');
            $this->s3 = new S3();
            //var_dump($s3);
            $this->server = Config::get('local.server');

    }

    public function index() {
        return View::make('settings/configSettings');
    }
	
	 public function active() {
        return View::make('settings.active.activeList');
    }
	 

    public function categoryListing() {
        $categoryListing = $this->db2->table('hr_category')->get();
        return View::make('settings.category.categoryListing')->with(array('category_list' => $categoryListing));
    }

    public function addCategory() {
        $postData = Input::all();
        if (!empty($postData)) {
            $category = trim(Input::get('category_name'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_category where category_name ="' . $category . '"'));
            if ($checkStatus[0]->count == 0) {
                $postData['category_name'] = $category;
                $insertStatus = $this->db2->table('hr_category')->insert($postData);
                if ($insertStatus)
                    return Redirect::to('config/category')->with('successalert', 'Category Created successfully');
            } else {
                return Redirect::to('config/add-category')->with('erroralert', 'Category already exists');
            }
        }
        return View::make('settings.category.addCategory');
    }

    public function editCategory() {
        $postData = Input::all();
        $id = Request::Segment(3);
        if (!empty($postData)) {
            $category = trim(Input::get('category_name'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_category where id!=' . $id . ' AND (category_name ="' . $category . '")'));
            if ($checkStatus[0]->count == 0) {
                $postData['date_modified'] = date('Y-m-d H:i:s');
                $postData['category_name'] = $category;
                $updateStatus = $this->db2->table('hr_category')->where('id', $id)->update($postData);
                return Redirect::to('config/category')->with('successalert', 'Category updated successfully');
            } else {
                return Redirect::to('config/edit-category/' . $id)->with('erroralert', 'Category already exists');
            }
        } else {
            $getCategory = $this->db2->table('hr_category')->where('id', $id)->first();
        }
        return View::make('settings.category.editCategory')->with(array('id' => $id, 'view' => $getCategory));
    }

    public function deleteCategory() {
        $id = Request::Segment(3);
        $checkStatus = $this->db2->select($this->db2->raw('select count(id) as emp_count from hr_emp_job_status where fkCategory_id=' . $id));
        if ($checkStatus[0]->emp_count == 0) {
            $delete = $this->db2->table('hr_category')->where('id', '=', $id)->delete();
            if ($delete)
                return Redirect::to('config/category')->with(array('successalert' => 'Category Deleted Successfully'));
            else
                return Redirect::to('config/category')->with(array('erroralert' => 'Server problem Try again'));
        } else {
            return Redirect::to('config/category')->with(array('erroralert' => 'Category already assigned so it cannot be deleted'));
        }
    }

    public function nationalityListing() {
        $nationalityListing = $this->db2->table('hr_nationality')->get();
        return View::make('settings.nationality.nationalityListing')->with(array('nationality_list' => $nationalityListing));
    }

    public function addNationality() {
        $postData = Input::all();
        if (!empty($postData)) {
            $code = trim(Input::get('nationality_code'));
            $name = trim(Input::get('nationality_name'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_nationality where nationality_name="' . $name . '" OR nationality_code="' . $code . '"'));
            if ($checkStatus[0]->count == 0) {
                $postData['nationality_code'] = $code;
                $postData['nationality_name'] = $name;
                $insertStatus = $this->db2->table('hr_nationality')->insert($postData);
                if ($insertStatus)
                    return Redirect::to('config/nationality')->with('successalert', 'Nationality Created successfully');
            } else {
                return Redirect::to('config/add-nationality')->with('erroralert', 'Nationality Code or Name already exists');
            }
        }
        return View::make('settings.nationality.addNationality');
    }

    public function editNationality() {
        $postData = Input::all();
        $id = Request::Segment(3);
        if (!empty($postData)) {
            $code = trim(Input::get('nationality_code'));
            $name = trim(Input::get('nationality_name'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_nationality where id!=' . $id . ' AND (nationality_name="' . $name . '" OR nationality_code ="' . $code . '")'));
            if ($checkStatus[0]->count == 0) {
                $postData['date_modified'] = date('Y-m-d H:i:s');
                $postData['nationality_code'] = $code;
                $postData['nationality_name'] = $name;
                $updateStatus = $this->db2->table('hr_nationality')->where('id', $id)->update($postData);
                return Redirect::to('config/nationality')->with('successalert', 'Nationality updated successfully');
            } else {
                return Redirect::to('config/edit-nationality/' . $id)->with('erroralert', 'Nationality Code or Name already exists');
            }
        } else {
            $getNationality = $this->db2->table('hr_nationality')->where('id', $id)->first();
        }
        return View::make('settings.nationality.editNationality')->with(array('id' => $id, 'view' => $getNationality));
    }

    public function deleteNationality() {
        $id = Request::Segment(3);
        $checkStatus = $this->db2->select($this->db2->raw('select count(id) as emp_count from hr_emp_info where nationality=' . $id));
        if ($checkStatus[0]->emp_count == 0) {
            $delete = $this->db2->table('hr_nationality')->where('id', '=', $id)->delete();
            if ($delete)
                return Redirect::to('config/nationality')->with(array('successalert' => 'Nationality Deleted Successfully'));
            else
                return Redirect::to('config/nationality')->with(array('erroralert' => 'Server problem Try again'));
        } else {
            return Redirect::to('config/nationality')->with(array('erroralert' => 'Nationality already assigned so it cannot be deleted'));
        }
    }

    //Designation Operation Starts

    public function addJobTitle() {
        /* get job title from db contract array */
        $jobQuery = $this->db2->table('hr_job_title')->select('id', 'job_title')->get();
        //return $jobQuery;        
        return View::make('settings/designation.designation')->with(array('jobTitleList' => $jobQuery));
    }

    public function insertJobTitle() {
        $jobTitle = trim(Input::get('job_title'));
        $jobQuery = $this->db2->table('hr_job_title')->select('id')->where('job_title', $jobTitle)->first();
        if (isset($jobQuery)) {
            return Redirect::to('config/designation/')->with(array('erroralert' => 'Position  ' . $jobTitle . ' already exists. '));
        } else {
            $insert = $this->db2->table('hr_job_title')->insert(array('job_title' => $jobTitle));
            if ($insert) {
                return Redirect::to('config/designation')->with('successalert', 'Position added successfully');
            }
        }
    }

    public function editJobTitle() {
        $id = Request::Segment(3);
        $designation = $this->db2->table('hr_job_title')->select('*')->where('id', $id)->first();
        $postData = Input::all();
        if (!empty($postData)) {
            $name = trim(Input::get('name'));
            $currentDate = date('Y-m-d H:i:s', strtotime('now'));
            $jobQuery = $this->db2->table('hr_job_title')->select('id')->where('job_title', $name)->where('id', '!=', $id)->first();
            if ($jobQuery) {
                return Redirect::to('config/designation')->with(array('erroralert' => 'Position name already exists'));
            } else {
                $update = $this->db2->table('hr_job_title')->where('id', $id)->update(array('job_title' => $name, 'dateModified' => $currentDate));
                if ($update)
                    return Redirect::to('config/designation')->with(array('successalert' => 'Position updated Successfully'));
                else
                    return Redirect::to('config/designation')->with(array('erroralert' => 'Server problem Try again'));
            }
        }
        return View::make('settings/designation.editDesignation')->with(array('view' => $designation, 'id' => $id));
    }

    public function deleteJobTitle() {
        $id = Request::Segment(3);
        //echo $id;die();
        $checkStatus = $this->db2->select($this->db2->raw('select count(id) as emp_count from hr_emp_info where fkJob_title_id=' . $id));
        if ($checkStatus[0]->emp_count == 0) {
            $delete = $this->db2->table('hr_job_title')->where('id', '=', $id)->delete();
            if ($delete)
                return Redirect::to('config/designation')->with(array('successalert' => 'Position Deleted Successfully'));
            else
                return Redirect::to('config/designation')->with(array('erroralert' => 'Server problem Try again'));
        } else {
            return Redirect::to('config/designation')->with(array('erroralert' => 'Position already assigned so it cannot be deleted'));
        }
    }

    //Designation Operation Starts
    //Location Operation Starts

    public function branchListing() {
        $postData = Input::all();
        if (!empty($postData)) {
            $branch_code = trim(Input::get('branch_code'));
            $branch_name = trim(Input::get('branch_name'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_branch where branch_code="' . $branch_code . '" OR branch_name="' . $branch_name . '"'));
            if ($checkStatus[0]->count == 0) {
                $postData['branch_code'] = $branch_code;
                $postData['branch_name'] = $branch_name;
                $insertStatus = $this->db2->table('hr_branch')->insert($postData);
                if ($insertStatus)
                    return Redirect::to('branch/branch-list')->with('successalert', 'Branch added successfully');
            } else {
                return Redirect::to('branch/branch-list')->with('erroralert', 'Branch Code OR Branch Name already exists');
            }
        }
        $getBranch = $this->db2->table('hr_branch')->select('id', 'branch_name', 'branch_code', 'address')->get();
        return View::make('settings/branch.branch')->with(array('branch_list' => $getBranch));
    }

    /* public function addBranch() {
      $postData = Input::all();
      if(!empty($postData)){
      $branch_code = Input::get('branch_code');
      $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_branch where branch_code="'.$branch_code.'"'));
      if($checkStatus[0]->count == 0) {
      $insertStatus = $this->db2->table('hr_branch')->insert($postData);
      if($insertStatus)
      return Redirect::to('branch/branch-list')->with('successalert','Branch updated successfully');
      } else {
      return Redirect::to('branch/add-branch')->with('erroralert','Branch Code already exists');
      }
      }
      return View::make('Company.branch.addBranch');
      } */
    /*
     * Purpose :  edit Branch Details
     * Return : boolean value
     */

    public function editBranch() {
        $postData = Input::all();
        $id = Request::Segment(3);
        if (!empty($postData)) {
            $branch_code = trim(Input::get('branch_code'));
            $branch_name = trim(Input::get('branch_name'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_branch where (branch_code="' . $branch_code . '" OR branch_name="' . $branch_name . '") AND id!=' . $id));
            if ($checkStatus[0]->count == 0) {
                $postData['branch_code'] = $branch_code;
                $postData['branch_name'] = $branch_name;
                $postData['dateModified'] = date('Y-m-d H:i:s');
                $updateStatus = $this->db2->table('hr_branch')->where('id', $id)->update($postData);
                return Redirect::to('branch/branch-list')->with('successalert', 'Branch updated successfully');
            } else {
                return Redirect::to('branch/edit-branch/' . $id)->with('erroralert', 'Branch Code OR Branch Name already exists');
            }
        } else {
            $getBranch = $this->db2->table('hr_branch')->select('id', 'branch_name', 'branch_code', 'address')->where('id', $id)->first();
        }
        //die('test');
        return View::make('settings.branch.editBranch')->with(array('id' => $id, 'bView' => $getBranch));
    }

    public function deleteBranch() {
        $id = Request::Segment(3);
        $checkStatus = $this->db2->select($this->db2->raw('select count(id) as emp_count from hr_emp_job_info where fkLocation_id=' . $id));
        if ($checkStatus[0]->emp_count == 0) {
            $delete = $this->db2->table('hr_branch')->where('id', '=', $id)->delete();
            if ($delete) {
                return Redirect::to('branch/branch-list')->with(array('successalert' => 'Branch Deleted Successfully'));
            } else {
                return Redirect::to('branch/branch-list')->with(array('erroralert' => 'Server problem Try again'));
            }
        } else {
            return Redirect::to('branch/branch-list')->with(array('erroralert' => 'Branch already assigned so it cannot be deleted'));
        }
    }

    //Location Operation Starts
    //Division Operation Starts

    public function addDivision() {
        /* get job title from db contract array */
        $jobQuery = $this->db2->table('hr_division')->select('id', 'div_name')->get();
        //return $jobQuery;        
        return View::make('settings/division.division')->with(array('divisionList' => $jobQuery));
    }

    public function insertDivision() {
        $division = trim(Input::get('division'));
        $divisionQuery = $this->db2->table('hr_division')->select('id')->where('div_name', $division)->first();
        if (isset($divisionQuery)) {
            return Redirect::to('config/division/')->with(array('erroralert' => 'Division  ' . $division . ' already exists. '));
        } else {
            $insert = $this->db2->table('hr_division')->insert(array('div_name' => $division));
            if ($insert) {
                return Redirect::to('config/division')->with('successalert', 'Division added successfully');
            }
        }
    }

    public function editDivision() {
        $id = Request::Segment(3);
        $division = $this->db2->table('hr_division')->select('*')->where('id', $id)->first();
        $postData = Input::all();
        if (!empty($postData)) {
            $name = trim(Input::get('division'));
            $currentDate = date('Y-m-d H:i:s', strtotime('now'));
            $divisionQuery = $this->db2->table('hr_division')->select('id')->where('div_name', $name)->where('id', '!=', $id)->first();
            if ($divisionQuery) {
                return Redirect::to('config/division')->with(array('erroralert' => 'Division name already exists'));
            } else {
                $update = $this->db2->table('hr_division')->where('id', $id)->update(array('div_name' => $name, 'date_modified' => $currentDate));
                if ($update)
                    return Redirect::to('config/division')->with(array('successalert' => 'Division updated Successfully'));
                else
                    return Redirect::to('config/division')->with(array('erroralert' => 'Server problem Try again'));
            }
        }
        return View::make('settings/division.editDivision')->with(array('view' => $division, 'id' => $id));
    }

    public function deleteDivision() {
        $id = Request::Segment(3);
        $checkStatus = $this->db2->select($this->db2->raw('select count(id) as emp_count from hr_emp_job_info where fkDivision_id=' . $id));
        if ($checkStatus[0]->emp_count == 0) {
            $delete = $this->db2->table('hr_division')->where('id', '=', $id)->delete();
            if ($delete)
                return Redirect::to('config/division')->with(array('successalert' => 'Division Deleted Successfully'));
            else
                return Redirect::to('config/division')->with(array('erroralert' => 'Server problem Try again'));
        } else {
            return Redirect::to('config/division')->with(array('erroralert' => 'Division already assigned so it cannot be deleted'));
        }
    }

    //Division Operation Starts
    //Department Operation Starts

    public function addDepartment() {
        /* get job title from db contract array */
        $department = $this->db2->table('hr_department')->select('id', 'department')->get();
        //return $jobQuery;        
        return View::make('settings/department.department')->with(array('departmentList' => $department));
    }

    public function insertDepartment() {
        $department = trim(Input::get('department'));
        $departQuery = $this->db2->table('hr_department')->select('id')->where('department', $department)->first();
        if (isset($departQuery)) {
            return Redirect::to('config/department/')->with(array('erroralert' => 'Department  ' . $department . ' already exists. '));
        } else {
            $insert = $this->db2->table('hr_department')->insert(array('department' => $department));
            if ($insert) {
                return Redirect::to('config/department')->with('successalert', 'Department added successfully');
            }
        }
    }

    public function editDepartment() {
        $id = Request::Segment(3);
        $department = $this->db2->table('hr_department')->select('*')->where('id', $id)->first();
        $postData = Input::all();
        if (!empty($postData)) {
            $name = trim(Input::get('department'));
            $currentDate = date('Y-m-d H:i:s', strtotime('now'));
            $divisionQuery = $this->db2->table('hr_department')->select('id')->where('department', $name)->where('id', '!=', $id)->first();
            if ($divisionQuery) {
                return Redirect::to('config/department')->with(array('erroralert' => 'Department name already exists'));
            } else {
                $update = $this->db2->table('hr_department')->where('id', $id)->update(array('department' => $name, 'dateModified' => $currentDate));
                if ($update)
                    return Redirect::to('config/department')->with(array('successalert' => 'Department updated Successfully'));
                else
                    return Redirect::to('config/department')->with(array('erroralert' => 'Server problem Try again'));
            }
        }
        return View::make('settings/department.editDepartment')->with(array('view' => $department, 'id' => $id));
    }

    public function deleteDepartment() {
        $id = Request::Segment(3);
        $checkStatus = $this->db2->select($this->db2->raw('select count(id) as emp_count from hr_emp_job_info where fkDepartment_id=' . $id));
        if ($checkStatus[0]->emp_count == 0) {
            $delete = $this->db2->table('hr_department')->where('id', '=', $id)->delete();
            if ($delete)
                return Redirect::to('config/department')->with(array('successalert' => 'Department Deleted Successfully'));
            else
                return Redirect::to('config/department')->with(array('erroralert' => 'Server problem Try again'));
        } else {
            return Redirect::to('config/department')->with(array('erroralert' => 'Department already assigned so it cannot be deleted'));
        }
    }

    //Department Operation Starts

    /*
     * Purpose : View Allowance
     * Return  : array value
     */
    public function allowance() {
        $allowance = $this->db2->table('hr_allowances')->select('id', 'fkcoa_id', 'allowance', 'default_amount')->orderby('id')->get();
        return View::make('settings/allowance.allowance')->with(array('allowances' => $allowance));
    }

    /*
     * Purpose : Add Allowance
     * Return   boolean value
     */

    public function addAllowance() {
        $postData = Input::all();
        if (!empty($postData)) {
            $allowance = trim(Input::get('allowance'));
            $defamount = str_replace(",", "", trim(Input::get('default_amount')));
            $default_amount = trim(str_replace('$', '', $defamount));
            if ($default_amount != 0) {
                $allowance_type = 1;
            } else {
                $allowance_type = 2;
            }

            $checkStatus = 0;

            //$checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from il_accounting_coa_level4 where level4_name="'.$name.'"'));
            $allowanceQuery = $this->db2->table('hr_allowances')->select('id', 'fkcoa_id', 'allowance', 'default_amount')->where('allowance', '=', $allowance)->first();
            if (!$allowanceQuery) {
                //$insertCoa = $this->db2->table('il_accounting_coa_level4')->insertGetId(array('level4_name' => $name,'fklevel3_id' => 27,'edit_status' => 2));
                $insert = $this->db2->table('hr_allowances')->insert(array('allowance' => $allowance, 'fkcoa_id' => 0, 'default_amount' => $default_amount, 'allowance_type' => $allowance_type));
                if ($insert)
                    return Redirect::to('config/allowance')->with(array('successalert' => 'Allowance added Successfully'));
                else
                    return Redirect::to('config/allowance')->with(array('erroralert' => 'Server problem Try again'));
            } else {
                return Redirect::to('config/allowance')->with(array('erroralert' => 'Allowance name already exists'));
            }
        }
        return Redirect::to('config/allowance');
    }

    /*
     * Purpose : edt Allowance
     * Return   boolean value
     */

    public function editAllowance() {
        $id = Request::Segment(3);
        $allowance = $this->db2->table('hr_allowances')->select('id', 'fkcoa_id', 'allowance', 'default_amount')->where('id', $id)->first();
        $postData = Input::all();
        if (!empty($postData)) {
            $name = trim(Input::get('allowance'));
            $defamount = str_replace(",", "", trim(Input::get('default_amount')));
            $default_amount = trim(str_replace('$', '', $defamount));
            if ($default_amount != 0) {
                $allowance_type = 1;
            } else {
                $allowance_type = 2;
            }
            // /$coa  = Input::get('coa_id');
            $currentDate = date('Y-m-d H:i:s', strtotime('now'));
            $checkStatus = 0;
            $allowance = $this->db2->table('hr_allowances')->select('id', 'fkcoa_id', 'allowance', 'default_amount')->where('id', '!=', $id)->where('allowance', '=', $name)->first();
            //$checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from il_accounting_coa_level4 where id!='.$coa.' AND level4_name="'.$name.'"'));
            if (!$allowance) {
                //$updateCoa = $this->db2->table('il_accounting_coa_level4')->where('id',$coa)->update(array('level4_name' => $name,'date_modified' => $currentDate));
                $update = $this->db2->table('hr_allowances')->where('id', $id)->update(array('allowance' => $name, 'default_amount' => $default_amount, 'allowance_type' => $allowance_type, 'date_modified' => $currentDate));
                if ($update)
                    return Redirect::to('config/allowance')->with(array('successalert' => 'Allowance updated Successfully'));
                else
                    return Redirect::to('config/allowance')->with(array('erroralert' => 'Server problem Try again'));
            } else {
                return Redirect::to('config/edit-allowance/' . $id)->with(array('erroralert' => 'Allowance name already exists'));
            }
        }
        return View::make('settings/allowance.editAllowance')->with(array('view' => $allowance, 'id' => $id));
    }

    /*
     * Purpose : Delete allowance if there is no employee assigned to that branch
     * Return boolean value
     */

    public function deleteAllowance() {
        $id = Request::Segment(3);
        //$coa = Request::Segment(5);
        $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_emp_allowance where fkAllowId=' . $id));
        if ($checkStatus[0]->count == 0) {
            //$delete = $this->db2->table('il_accounting_coa_level4')->where('id','=',$coa)->delete();
            $delete = $this->db2->table('hr_allowances')->where('id', '=', $id)->delete();
            if ($delete)
                return Redirect::to('config/allowance')->with(array('successalert' => 'Allowance Deleted Successfully'));
            else
                return Redirect::to('config/allowance')->with(array('erroralert' => 'Server problem Try again'));
        } else {
            return Redirect::to('config/allowance')->with(array('erroralert' => 'Allowance already assigned so it cannot be deleted'));
        }
    }

    //Delete Allowance

    public function residentialStatus() {
        $residentialStatus = $this->db2->table('hr_residential_status')->select('id', 'residential_status', 'vstatus')->orderby('id')->get();
        return View::make('settings.residential.residentialStatus')->with(array('residentialStatus' => $residentialStatus));
    }

    public function addresidentialStatus() {
        $postData = Input::all();
        if (!empty($postData)) {
            $name = trim(Input::get('name'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_residential_status where residential_status="' . $name . '"'));
            if ($checkStatus[0]->count == 0) {
                $insert = $this->db2->table('hr_residential_status')->insert(array('residential_status' => $name));
                if ($insert)
                    return Redirect::to('config/residential-status')->with(array('successalert' => 'Residential Status added Successfully'));
                else
                    return Redirect::to('config/residential-status')->with(array('erroralert' => 'Server problem Try again'));
            } else {
                return Redirect::to('config/add-residential-status')->with(array('erroralert' => 'Name already exists'));
            }
        }
        return View::make('settings.residential.addResidentialStatus');
    }

    public function editresidentialStatus() {
        $id = Request::Segment(3);
        $residentialStatus = $this->db2->table('hr_residential_status')->select('residential_status', 'id')->where('id', $id)->first();
        $postData = Input::all();
        if (!empty($postData)) {
            $name = trim(Input::get('name'));
            $currentDate = date('Y-m-d H:i:s', strtotime('now'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_residential_status where id!=' . $id . ' AND (residential_status="' . $name . '")'));
            if ($checkStatus[0]->count == 0) {
                $update = $this->db2->table('hr_residential_status')->where('id', $id)->update(array('residential_status' => $name, 'date_modified' => $currentDate));
                if ($update)
                    return Redirect::to('config/residential-status')->with(array('successalert' => 'Residential Status updated Successfully'));
                else
                    return Redirect::to('config/residential-status')->with(array('erroralert' => 'Server problem Try again'));
            } else {
                return Redirect::to('config/edit-residential-status/' . $id)->with('erroralert', 'Name already exists');
            }
        }
        return View::make('settings.residential.editResidentialStatus')->with(array('view' => $residentialStatus, 'id' => $id));
    }

    public function deleteresidentialStatus() {
        $id = Request::Segment(3);
        $checkStatus = $this->db2->select($this->db2->raw('select count(id) as emp_count from hr_emp_info where fkResidential_status=' . $id));
        if ($checkStatus[0]->emp_count == 0) {
            $delete = $this->db2->table('hr_residential_status')->where('id', '=', $id)->delete();
            if ($delete)
                return Redirect::to('config/residential-status')->with(array('successalert' => 'Residential Status Deleted Successfully'));
            else
                return Redirect::to('config/residential-status')->with(array('erroralert' => 'Server problem Try again'));
        } else {
            return Redirect::to('config/residential-status')->with(array('erroralert' => 'Residential Status already assigned so it cannot be deleted'));
        }
    }

    public function pobListing() {
        $pobListing = $this->db2->table('hr_pob')->get();
        return View::make('settings.pob.pobListing')->with(array('pob_list' => $pobListing));
    }

    public function addPob() {
        $postData = Input::all();
        if (!empty($postData)) {
            $pob = trim(Input::get('place_of_birth'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_pob where place_of_birth ="' . $pob . '"'));
            if ($checkStatus[0]->count == 0) {
                $insertStatus = $this->db2->table('hr_pob')->insert($postData);
                if ($insertStatus)
                    return Redirect::to('config/pob')->with('successalert', 'Country of Birth created successfully');
            } else {
                return Redirect::to('config/add-pob')->with('erroralert', 'Country of Birth already exists');
            }
        }
        return View::make('settings.pob.addPob');
    }

    public function editPob() {
        $postData = Input::all();
        $id = Request::Segment(3);
        if (!empty($postData)) {
            $pob = trim(Input::get('place_of_birth'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_pob where id!=' . $id . ' AND (place_of_birth ="' . $pob . '")'));
            if ($checkStatus[0]->count == 0) {
                $postData['date_modified'] = date('Y-m-d H:i:s');
                $updateStatus = $this->db2->table('hr_pob')->where('id', $id)->update($postData);
                return Redirect::to('config/pob')->with('successalert', 'Country of Birth updated successfully');
            } else {
                return Redirect::to('config/edit-pob/' . $id)->with('erroralert', 'Country of Birth already exists');
            }
        } else {
            $getPob = $this->db2->table('hr_pob')->where('id', $id)->first();
        }
        return View::make('settings.pob.editPob')->with(array('id' => $id, 'view' => $getPob));
    }

    public function deletePob() {
        $id = Request::Segment(3);
        $checkStatus = $this->db2->select($this->db2->raw('select count(id) as emp_count from hr_emp_info where country_of_birth=' . $id));
        if ($checkStatus[0]->emp_count == 0) {
            $delete = $this->db2->table('hr_pob')->where('id', '=', $id)->delete();
            if ($delete)
                return Redirect::to('config/pob')->with(array('successalert' => 'Country of Birth deleted Successfully'));
            else
                return Redirect::to('config/pob')->with(array('erroralert' => 'Server problem Try again'));
        } else {
            return Redirect::to('config/pob')->with(array('erroralert' => 'Country of Birth already assigned so it cannot be deleted'));
        }
    }

    public function race() {
        $race = $this->db2->table('hr_race')->select('id', 'race')->orderby('id')->get();
        return View::make('settings.race.race')->with(array('races' => $race));
    }

    public function addRace() {
        $postData = Input::all();
        if (!empty($postData)) {
            $name = trim(Input::get('name'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_race where (race="' . $name . '")'));
            if ($checkStatus[0]->count == 0) {
                $insert = $this->db2->table('hr_race')->insert(array('race' => $name));
                if ($insert)
                    return Redirect::to('config/race')->with(array('successalert' => 'Race added Successfully'));
                else
                    return Redirect::to('config/race')->with(array('erroralert' => 'Server problem Try again'));
            } else {
                return Redirect::to('config/add-race')->with(array('erroralert' => 'Race already exists'));
            }
        }
        return View::make('settings.race.addRace');
    }

    public function editRace() {
        $id = Request::Segment(3);
        $races = $this->db2->table('hr_race')->select('race', 'id')->where('id', $id)->first();
        $postData = Input::all();
        if (!empty($postData)) {
            $name = trim(Input::get('name'));
            $currentDate = date('Y-m-d H:i:s', strtotime('now'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_race where id!=' . $id . ' AND (race="' . $name . '")'));
            if ($checkStatus[0]->count == 0) {
                $update = $this->db2->table('hr_race')->where('id', $id)->update(array('race' => $name, 'date_modified' => $currentDate));
                if ($update)
                    return Redirect::to('config/race')->with(array('successalert' => 'Race updated Successfully'));
                else
                    return Redirect::to('config/race')->with(array('erroralert' => 'Server problem Try again'));
            } else {
                return Redirect::to('config/edit-race/' . $id)->with('erroralert', 'Race already exists');
            }
        }
        return View::make('settings.race.editRace')->with(array('view' => $races, 'id' => $id));
    }

    public function deleteRace() {
        $id = Request::Segment(3);
        $checkStatus = $this->db2->select($this->db2->raw('select count(id) as emp_count from hr_emp_info where fkrace=' . $id));
        if ($checkStatus[0]->emp_count == 0) {
            $delete = $this->db2->table('hr_race')->where('id', '=', $id)->delete();
            if ($delete)
                return Redirect::to('config/race')->with(array('successalert' => 'Race Deleted Successfully'));
            else
                return Redirect::to('config/race')->with(array('erroralert' => 'Server problem Try again'));
        } else {
            return Redirect::to('config/race')->with(array('erroralert' => 'Race already assigned so it cannot be deleted'));
        }
    }

    public function martialStatusListing() {
        $martialStatusListing = $this->db2->table('hr_martial_status')->get();
        return View::make('settings.martial.martialStatusListing')->with(array('martial_status_list' => $martialStatusListing));
    }

    public function addMartialStatus() {
        $postData = Input::all();
        if (!empty($postData)) {
            $martial = trim(Input::get('martial_status'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_martial_status where martial_status ="' . $martial . '"'));
            if ($checkStatus[0]->count == 0) {
                $insertStatus = $this->db2->table('hr_martial_status')->insert(array('martial_status' => $martial));
                if ($insertStatus)
                    return Redirect::to('config/martial-status')->with('successalert', 'Martial Status Created successfully');
            } else {
                return Redirect::to('config/add-martial-status')->with('erroralert', 'Martial Status already exists');
            }
        }
        return View::make('settings.martial.addMartialStatus');
    }

    public function editMartialStatus() {
        $postData = Input::all();
        $id = Request::Segment(3);
        if (!empty($postData)) {
            $martial = trim(Input::get('martial_status'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_martial_status where id!=' . $id . ' AND (martial_status ="' . $martial . '")'));
            if ($checkStatus[0]->count == 0) {
                $postData['date_modified'] = date('Y-m-d H:i:s');
                $postData['martial_status'] = $martial;
                $updateStatus = $this->db2->table('hr_martial_status')->where('id', $id)->update($postData);
                return Redirect::to('config/martial-status')->with('successalert', 'Martial Status updated successfully');
            } else {
                return Redirect::to('config/edit-martial-status/' . $id)->with('erroralert', 'Martial Status already exists');
            }
        } else {
            $getMartial = $this->db2->table('hr_martial_status')->where('id', $id)->first();
        }
        return View::make('settings.martial.editMartialStatus')->with(array('id' => $id, 'view' => $getMartial));
    }

    public function deleteMartialStatus() {
        $id = Request::Segment(3);
        $checkStatus = $this->db2->select($this->db2->raw('select count(id) as emp_count from hr_emp_info where marital_status=' . $id));
        if ($checkStatus[0]->emp_count == 0) {
            $delete = $this->db2->table('hr_martial_status')->where('id', '=', $id)->delete();
            if ($delete)
                return Redirect::to('config/martial-status')->with(array('successalert' => 'Martial Status Deleted Successfully'));
            else
                return Redirect::to('config/martial-status')->with(array('erroralert' => 'Server problem Try again'));
        } else {
            return Redirect::to('config/martial-status')->with(array('erroralert' => 'Martial Status already assigned so it cannot be deleted'));
        }
    }

    public function leaveTypeListing() {
        $leaveListing = $this->db2->table('hr_leave_types')->get();
        return View::make('settings.leave.leaveTypeListing')->with(array('leave_list' => $leaveListing));
    }

    public function addLeaveType() {
        $postData = Input::all();
        if (!empty($postData)) {
            $name = trim(Input::get('leave_type_name'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_leave_types where leave_type_name ="' . $name . '"'));
            if ($checkStatus[0]->count == 0) {
                $postData['leave_type_name'] = $name;
                $insertStatus = $this->db2->table('hr_leave_types')->insert($postData);
                if ($insertStatus)
                    return Redirect::to('config/leave-type')->with('successalert', 'Leave Type Created successfully');
            } else {
                return Redirect::to('config/add-leave-type')->with('erroralert', 'Leave Type already exists');
            }
        }
        return View::make('settings.leave.addLeaveType');
    }

    public function editLeaveType() {
        $postData = Input::all();
        $id = Request::Segment(3);
        if (!empty($postData)) {
            $name = trim(Input::get('leave_type_name'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_leave_types where id!=' . $id . ' AND (leave_type_name ="' . $name . '")'));
            if ($checkStatus[0]->count == 0) {
                $postData['dateModified'] = date('Y-m-d H:i:s');
                $postData['leave_type_name'] = $name;
                $updateStatus = $this->db2->table('hr_leave_types')->where('id', $id)->update($postData);
                return Redirect::to('config/leave-type')->with('successalert', 'Leave Type updated successfully');
            } else {
                return Redirect::to('config/edit-leave-type/' . $id)->with('erroralert', 'Leave Type already exists');
            }
        } else {
            $getMartial = $this->db2->table('hr_leave_types')->where('id', $id)->first();
        }
        return View::make('settings.leave.editLeaveType')->with(array('id' => $id, 'view' => $getMartial));
    }

    public function deleteLeaveType() {
        $id = Request::Segment(3);
        $checkStatus = $this->db2->select($this->db2->raw('select count(id) as emp_count from hr_leave_policies where fkLeave_type_id=' . $id));
        if ($checkStatus[0]->emp_count == 0) {
            $delete = $this->db2->table('hr_leave_types')->where('id', '=', $id)->delete();
            if ($delete)
                return Redirect::to('config/leave-type')->with(array('successalert' => 'Leave Type Deleted Successfully'));
            else
                return Redirect::to('config/leave-type')->with(array('erroralert' => 'Server problem Try again'));
        } else {
            return Redirect::to('config/leave-type')->with(array('erroralert' => 'Leave Type already assigned so it cannot be deleted'));
        }
    }

    public function companyUserSettings() {
        $vMode = Request::get('vmode');
        if (Session::has('proxy_cpy_id')) {
            $companyId = Session::get('proxy_cpy_id');
        } else {
            $companyId = Session::get('cpy_id');
        }
        $getCpy = DB::table('hr_login_credentials as t1')
                ->select('t1.id', 't1.username', 't1.account_type', 't1.muliple_option','t1.account_status', 't1.fkUserId')
                ->where('t1.fkCompany_id', $companyId)
                ->where('t1.account_type', '!=', '1');
        if (!empty($vMode)) {
            if ($vMode != 3)
                $getCpy = $getCpy->where('t1.account_status', $vMode);
        } else {
            $getCpy = $getCpy->where('t1.account_status', 1);
        }
        $getCpy = $getCpy->get();
		 $com_name = Session::get('proxy_cpy_name') ? Session::get('proxy_cpy_name') : Session::get('cpy_name');
		
        $emp = $this->db2->table('hr_emp_info')->where(array('local_del' => 0))->get();

        return View::Make('settings.company.companyUserListing')->with(array('users' => $getCpy, 'vmode' => $vMode, 'emp' => $emp));
    }

    public function userListing() {
        $getCpy = DB::table('hr_login_credentials as users')
                        ->join('hr_company_dtls as comp', 'comp.id', "=", 'users.fkCompany_id')
                        ->select('users.*', 'comp.company_name')->where('users.account_status', '=', '1')->get();
        $ComDb = $this->companyDBListing();
        //print_r(DB::getQueryLog());
        //print_r($getCpy);die;          
        //echo"<pre>";print_r($ComDb);die();          
        return View::Make('Developer.userListing')->with(array('users' => $getCpy, 'company' => $ComDb));
    }
	
	

    public function leavePolicies() {
        $policies = $this->db2->table('hr_leave_policies as lp')
                ->join('hr_leave_types as lt', 'lt.id', '=', 'lp.fkLeave_type_id')
                ->select('lp.*', 'lt.leave_type_name')
                ->get();
        return View::make('settings.leavePolicies.leavePolicies')->with(array('policies' => $policies));
    }

 public function addLeavePolicy() {
        $postData = Input::all();
        if (!empty($postData)) {
            $effective_date = date('Y-m-d', strtotime($postData['effective_date']));
            if (!empty($postData['carry_over_date'] )) {
                $carry_over_date = date('Y-m-d', strtotime($postData['carry_over_date']));
                $carry_over_hour = $postData['carry_over_hour'];
            } else {
                $carry_over_date = NULL;
                $carry_over_hour = 0;
            }

            $insert_array = array('fkLeave_type_id' => $postData['leave_type_name'],
                'policy_name' => trim($postData['policy_name']),
                'effective_date' => $effective_date,
                'effective_hours' => $postData['effective_hour'],
                'carry_over_date' => $carry_over_date,
                'carry_over_hours' => $carry_over_hour,
               // 'first_accrual' => $postData['first_accrual']
            );
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_leave_policies where fkLeave_type_id=' . $postData['leave_type_name'] . ' AND (policy_name="' . trim($postData['policy_name']) . '")'));
            if ($checkStatus[0]->count == 0) {
                $insertStatus = $this->db2->table('hr_leave_policies')->insert($insert_array);
            }

            /* $id = $this->db2->table('hr_leave_policies')->select('id')->orderBy('id' ,'desc')->get();
              if($id)
              { */
            $start = Input::get("start");
            $amount = Input::get("amount");
            $accrual_date = Input::get("accrual_date");
            $accrual = Input::get("accrual");
            $accrual_type = Input::get("accrual_type");
            $accural_month = Input::get("accural_month");
            $carry_over_type = Input::get("carry_over_type");
            $carry_over = Input::get("carry_over");
            $max_accrual = Input::get("max_accrual");
            $leave_type = $postData['leave_type_name'];
            $j = 1;

            for ($i = 0; $i < count($start); $i++) {

                $insert_val = $this->db2->table('hr_accural_leave')->insert(array(
                    'fkLeave_type_id' => $leave_type,
                    'start' => $start[$i],
                    'sort' => $j,
                    'accrual_amt' => isset($amount[$i]) ? $amount[$i] : 0,
                    'accrual_date' => $accrual_date[$i],
					'accrual_level'=>$accrual[$i],
                    'accrual_type' => $accrual_type[$i],
                    'accural_month' => $accural_month[$i],
                    'carry_over_type' => $carry_over_type[$i],
                    'carry_over' => $carry_over[$i],
                    'max_accrual' => $max_accrual[$i],
                    'effective_date' => $effective_date
                ));
                $j++;
            }
            if (($insertStatus) && ($insert_val)) {
                return Redirect::to('config/leave-policy')->with('successalert', 'Leave Policy Created successfully');
            } else {
                return Redirect::to('config/add-leave-policy')->with('erroralert', 'Leave type and Policy Name already exists');
            }
        } else {
            $leaveType = $this->db2->table('hr_leave_types')->orderBy('leave_type_name')->get();
            $empid = Session::has('proxy_user_id') ? Session::get('proxy_user_id') : Session::get('user_id');
            $hire_date = $this->db2->table('hr_emp_job_status')
                    ->select('hr_emp_job_status.hire_date')
                    ->where('hr_emp_job_status.fkEmp_id', $empid)
                    ->where('hr_emp_job_status.is_delete', '1')
                    ->orderBy('hr_emp_job_status.id', 'asc')
                    ->first();
            if (count($hire_date) > 0) {
                $hire_date = $hire_date->hire_date;
            } else {
                $hire_date = '';
            }
            return View::make('settings.leavePolicies.addLeavePolicy')->with(array('leaveType' => $leaveType, 'hiredate' => $hire_date));
        }
    }

    public function editLeavePolicy() {
        $postData = Input::all();

        $id = Request::Segment(3);
        if (!empty($postData)) {
            $effective_date = date('Y-m-d', strtotime($postData['effective_date']));
            if (!empty($postData['carry_over_date'] )) {
                $carry_over_date = date('Y-m-d', strtotime($postData['carry_over_date']));
                $carry_over_hour = $postData['carry_over_hour'];
            } else {
                $carry_over_date = NULL;
                $carry_over_hour = 0;
            }
           /* $dates = explode(' ', $postData['carry_over_date']);
            $cmonth = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
            $month = array('1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'Jun', '7' => 'Jul', '8' => 'Aug', '9' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
            $cmonth = array_search($dates[1], $month);
            $carry_over_date = date("Y") . '-' . $cmonth . '-' . $dates[0];
            $today = date('Y-m-d');
            if ($today >= $carry_over_date) {
                $carry_over_date = (date("Y") + 1) . '-' . $cmonth . '-' . $dates[0];
            } else {
                $carry_over_date = date("Y") . '-' . $cmonth . '-' . $dates[0];
            }*/
            $get = $this->db2->table('hr_leave_policies')->where('id', $id)->first();
            $start = Input::get("start");
            $amount = Input::get("accrual_amt");
            $accrual_date = Input::get("accrual_date");
            $accrual = Input::get("accrual");
            $accrual_type = Input::get("accrual_type");
            $accural_month = Input::get("accural_month");
            $carry_over_type = Input::get("carry_over_type");
            $carry_over = Input::get("carry_over");
            $max_accrual = Input::get("max_accrual");
            $leave_type = $postData['leave_type_name'];
            $sort = $postData['sort'];
            $j = 1;
            $this->db2->table('hr_accural_leave')->where('effective_date', $get->effective_date)->where('fkLeave_type_id', $get->fkLeave_type_id)->delete();
            for ($i = 0; $i < count($start); $i++) {

                $insert_val = $this->db2->table('hr_accural_leave')
                        ->insert(array(
                    'fkLeave_type_id' => $postData['leave_type_name'],
                    'start' => $start[$i],
                    'sort' => $j,
					'accrual_level'=>$accrual[$i],
                    'accrual_amt' => $amount[$i],
                    'accrual_date' => $accrual_date[$i],
                    'accrual_type' => $accrual_type[$i],
                    'accural_month' => $accural_month[$i],
                    'carry_over_type' => $carry_over_type[$i],
                    'carry_over' => $carry_over[$i],
                    'max_accrual' => $max_accrual[$i],
                    'effective_date' => $effective_date
                ));
                $j++;
            }
            $update_array = array('fkLeave_type_id' => $postData['leave_type_name'],
                'policy_name' => trim($postData['policy_name']),
                'effective_date' => $effective_date,
                'effective_hours' => $postData['effective_hour'],
                'carry_over_date' => $carry_over_date,
                'carry_over_hours' => $carry_over_hour,
                //'first_accrual' => $postData['first_accrual'],
                //  'accrual_happens' => $postData['accrual_happens'],
                'date_modified' => date('Y-m-d H:i:s')
            );
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_leave_policies where fkLeave_type_id=' . $postData['leave_type_name'] . ' AND id != ' . $id . ' AND (policy_name="' . trim($postData['policy_name']) . '")'));
            if ($checkStatus[0]->count == 0) {
                $updateStatus = $this->db2->table('hr_leave_policies')->where('id', $id)->update($update_array);
                $getAllEmpPolicies = $this->db2->table('hr_emp_policies')->where('fkPolicy_id', $id)->select('id', 'opening_balance')->get();
                if (!empty($getAllEmpPolicies)) {
                    foreach ($getAllEmpPolicies as $getAllEmpPolicy) {
                        $log_update = array('opening_balance' => $getAllEmpPolicy->opening_balance, 'closing_balance' => $getAllEmpPolicy->opening_balance, 'refer_date' => '');
                        $this->db2->table('hr_emp_policies')->where('id', $getAllEmpPolicy->id)->update($log_update);
                    }
                }

                return Redirect::to('config/leave-policy')->with('successalert', 'Leave Policy updated successfully');
            } else {
                return Redirect::to('config/edit-leave-policy/' . $id)->with('erroralert', 'Leave type and Policy Name already exists');
            }
        } else {
            $leaveType = $this->db2->table('hr_leave_types')->orderBy('leave_type_name')->get();
            $getPolicy = $this->db2->table('hr_leave_policies')->where('id', $id)->first();
            if (!empty($getPolicy)) {
                $getaccrual = $this->db2->table('hr_accural_leave')
                        ->where('effective_date', $getPolicy->effective_date)
                        ->where('fkLeave_type_id', $getPolicy->fkLeave_type_id)
                        ->get();
            }
            return View::make('settings.leavePolicies.editLeavePolicy')->with(array('id' => $id, 'getPolicy' => $getPolicy, 'leaveType' => $leaveType, 'accrual' => $getaccrual));
        }
    }

    public function deleteLeavePolicy() {
        $id = Request::Segment(3);
        $checkStatus = $this->db2->select($this->db2->raw('select count(id) as emp_count from hr_emp_policies where fkPolicy_id=' . $id));
        if ($checkStatus[0]->emp_count == 0) {
            $delete = $this->db2->table('hr_leave_policies')->where('id', '=', $id)->delete();
            if ($delete) {
                return Redirect::to('config/leave-policy')->with(array('successalert' => 'Leave Policy Deleted Successfully'));
            } else {
                return Redirect::to('config/leave-policy')->with(array('erroralert' => 'Server problem Try again'));
            }
        } else {
            return Redirect::to('config/leave-policy')->with(array('erroralert' => 'Leave Policy already assigned so it cannot be deleted'));
        }
    }

    public function blackoutListing() {
        $bloackoutListing = $this->db2->table('hr_leave_blackout_period as blackout')
                ->select('blackout.id', 'blackout.from_date', 'blackout.to_date', 'blackout.reason')
                ->get();

        return View::make('settings.blackout.blackoutListing')->with(array('bloackoutListing' => $bloackoutListing));
    }

    public function deleteBlackout() {
        $id = Request::Segment(4);
        $delete = $this->db2->table('hr_leave_blackout_period')->where('id', '=', $id)->delete();
        if ($delete) {
            return Redirect::to('config/blackout/calendar-list')->with(array('successalert' => 'Leave Blackout Period Deleted Successfully'));
        } else {
            return Redirect::to('config/blackout/calendar-list')->with(array('erroralert' => 'Server problem Try again'));
        }
    }

    public function addBlackout() {
        $postData = Input::all();
        if (!empty($postData)) {
            $insert_array = array('from_date' => date('Y-m-d', strtotime($postData['from_date'])),
                'to_date' => date('Y-m-d', strtotime($postData['to_date'])),
                'reason' => $postData['reason'],
                'dateModified' => date('Y-m-d H:i:s')
            );
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_leave_blackout_period where from_date ="' . date('Y-m-d', strtotime($postData['from_date'])) . '" AND to_date ="' . date('Y-m-d', strtotime($postData['to_date'])) . '"'));
            if ($checkStatus[0]->count == 0) {
                $insertStatus = $this->db2->table('hr_leave_blackout_period')->insert($insert_array);
                if ($insertStatus) {
                    return Redirect::to('config/blackout/calendar-list')->with('successalert', 'Leave Blackout Period Created successfully');
                } else {
                    return Redirect::to('config/blackout/calendar-list')->with(array('erroralert' => 'Server problem Try again'));
                }
            } else {
                return Redirect::to('config/blackout/calendar-list')->with('erroralert', 'This combination already exists');
            }
        }
        //$calender = $this->db2->table('hr_calendar_config')->select('id','cal_name')->get();

        return View::make('settings.blackout.addBlackout');
    }

    public function editBlackout() {
        $postData = Input::all();
        $id = Request::Segment(4);
        $getblackout = $this->db2->table('hr_leave_blackout_period')->where('id', $id)->first();
        //$calender = $this->db2->table('hr_calendar_config')->select('id','cal_name')->get();
        if (!empty($postData)) {
            $update_array = array('from_date' => date('Y-m-d', strtotime($postData['from_date'])),
                'to_date' => date('Y-m-d', strtotime($postData['to_date'])),
                'reason' => $postData['reason'],
                'dateModified' => date('Y-m-d H:i:s')
            );
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_leave_blackout_period where id !="' . $id . '"  AND from_date ="' . date('Y-m-d', strtotime($postData['from_date'])) . '" AND to_date ="' . date('Y-m-d', strtotime($postData['to_date'])) . '"'));
            if ($checkStatus[0]->count == 0) {
                $updateStatus = $this->db2->table('hr_leave_blackout_period')->where('id', $id)->update($update_array);
                if ($updateStatus) {
                    return Redirect::to('config/blackout/calendar-list')->with('successalert', 'Leave Blackout Period Updated successfully');
                } else {
                    return Redirect::to('config/blackout/calendar-list')->with(array('erroralert' => 'Server problem Try again'));
                }
            } else {
                return Redirect::to('config/blackout/calendar-list')->with('erroralert', 'This combination already exists');
            }
        }
        return View::make('settings.blackout.editBlackout')->with(array('id' => $id, 'view' => $getblackout));
    }

    public function employementCategoryListing() {
        $categoryListing = $this->db2->table('hr_employement_category')->get();
        return View::make('settings.employementCategory.categoryListing')->with(array('category_list' => $categoryListing));
    }

    public function addEmployementCategory() {
        $postData = Input::all();
        if (!empty($postData)) {
            $category = trim(Input::get('category_name'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_employement_category where category_name ="' . $category . '"'));
            if ($checkStatus[0]->count == 0) {
                $postData['category_name'] = $category;
                $insertStatus = $this->db2->table('hr_employement_category')->insert($postData);
                if ($insertStatus)
                    return Redirect::to('config/employement_category')->with('successalert', 'Category Created successfully');
            } else {
                return Redirect::to('config/add-employement_category')->with('erroralert', 'Status already exists');
            }
        }
        return View::make('settings.employementCategory.addCategory');
    }

    public function editEmployementCategory() {
        $postData = Input::all();
        $id = Request::Segment(3);
        if (!empty($postData)) {
            $category = trim(Input::get('category_name'));
            $checkStatus = $this->db2->select($this->db2->raw('select count(id) as count from hr_employement_category where id!=' . $id . ' AND (category_name ="' . $category . '")'));
            if ($checkStatus[0]->count == 0) {
                $postData['date_modified'] = date('Y-m-d H:i:s');
                $postData['category_name'] = $category;
                $updateStatus = $this->db2->table('hr_employement_category')->where('id', $id)->update($postData);
                return Redirect::to('config/employement_category')->with('successalert', 'Category updated successfully');
            } else {
                return Redirect::to('config/edit-employement_category/' . $id)->with('erroralert', 'Status already exists');
            }
        } else {
            $getCategory = $this->db2->table('hr_employement_category')->where('id', $id)->first();
        }
        return View::make('settings.employementCategory.editCategory')->with(array('id' => $id, 'view' => $getCategory));
    }

    public function calendarList() {
        $getCal = $this->db2->table('hr_calendar_config')->select('id', 'cal_name', 'cal_type', 'cal_type_half', 'cal_year', 'mon', 'tue', 'wed', 'thurs', 'fri', 'sat', 'sun', 'alt_holiday', 'max_hours', 'min_hours')->get();
        return View::make('settings.calendar.calendarList')->with(array('calList' => $getCal));
    }

    public function addCalendarConfig() {
        $postData = Input::all();
        if (!empty($postData)) {
            $calName = trim(Input::get('cal_name'));
            $calType = trim(Input::get('cal_type'));
            $calTypeHalf = trim(Input::get('cal_type_half'));
            $cYear = trim(Input::get('cal_year'));
            $max_hours = Input::get('max_hours');
            $min_hours = Input::get('min_hours');
            $half_max=Input::get('half_max_hours');
            $sun = Input::get('sun');
            $mon = Input::get('mon');
            $tue = Input::get('tue');
            $wed = Input::get('wed');
            $thurs = Input::get('thurs');
            $fri = Input::get('fri');
            $sat = Input::get('sat');

            if ($sun == 1) {
                $sun = 0;
            } elseif ($sun == 2) {
                $sun = 10;
            } else {
                $sun = 9;
            }
            if ($mon == 1) {
                $mon = 1;
            } elseif ($mon == 2) {
                $mon = 10;
            } else {
                $mon = 9;
            }
            if ($tue == 1) {
                $tue = 2;
            } elseif ($tue == 2) {
                $tue = 10;
            } else {
                $tue = 9;
            }
            if ($wed == 1) {
                $wed = 3;
            } elseif ($wed == 2) {
                $wed = 10;
            } else {
                $wed = 9;
            }
            if ($thurs == 1) {
                $thurs = 4;
            } elseif ($thurs == 2) {
                $thurs = 10;
            } else {
                $thurs = 9;
            }
            if ($fri == 1) {
                $fri = 5;
            } elseif ($fri == 2) {
                $fri = 10;
            } else {
                $fri = 9;
            }
            if ($sat == 1) {
                $sat = 6;
            } elseif ($sat == 2) {
                $sat = 10;
            } else {
                $sat = 9;
            }

           $insertArray = array('cal_name' => $calName, 'cal_type' => $calType, 'cal_type_half' => $calTypeHalf, 'cal_year' => $cYear, 'mon' => $mon, 'tue' => $tue, 'wed' => $wed, 'thurs' => $thurs, 'fri' => $fri, 'sat' => $sat, 'sun' => $sun,
                                'max_hours' => $max_hours, 'min_hours' => $min_hours, 'half_max_hours' => $half_max);
            $insertStatus = $this->db2->table('hr_calendar_config')->insert($insertArray);
            if ($insertStatus) {
                return Redirect::to('config/calendar/calendar-list')->with('successalert', 'Calendar added successfully');
            }
        }
        return View::make('settings.calendar.addCalendar');
    }

    public function editCalendarConfig() {
        $id = Request::Segment(4);
        $getCalInfo = $this->db2->table('hr_calendar_config')->where('id', $id)->first();
        $postData = Input::all();
        if (!empty($postData)) {
            $calName = trim(Input::get('cal_name'));
            $calType = trim(Input::get('cal_type'));
            $calTypeHalf = trim(Input::get('cal_type_half'));
            $cYear = trim(Input::get('cal_year'));
            $max_hours = Input::get('max_hours');
            $min_hours = Input::get('min_hours');
            $half_max=Input::get('half_max_hours');
            $sun = Input::get('sun');
            $mon = Input::get('mon');
            $tue = Input::get('tue');
            $wed = Input::get('wed');
            $thurs = Input::get('thurs');
            $fri = Input::get('fri');
            $sat = Input::get('sat');

            if ($sun == 1) {
                $sun = 0;
            } elseif ($sun == 2) {
                $sun = 10;
            } else {
                $sun = 9;
            }
            if ($mon == 1) {
                $mon = 1;
            } elseif ($mon == 2) {
                $mon = 10;
            } else {
                $mon = 9;
            }
            if ($tue == 1) {
                $tue = 2;
            } elseif ($tue == 2) {
                $tue = 10;
            } else {
                $tue = 9;
            }
            if ($wed == 1) {
                $wed = 3;
            } elseif ($wed == 2) {
                $wed = 10;
            } else {
                $wed = 9;
            }
            if ($thurs == 1) {
                $thurs = 4;
            } elseif ($thurs == 2) {
                $thurs = 10;
            } else {
                $thurs = 9;
            }
            if ($fri == 1) {
                $fri = 5;
            } elseif ($fri == 2) {
                $fri = 10;
            } else {
                $fri = 9;
            }
            if ($sat == 1) {
                $sat = 6;
            } elseif ($sat == 2) {
                $sat = 10;
            } else {
                $sat = 9;
            }

           $updateArray = array('cal_name' => $calName, 'cal_type' => $calType, 'cal_type_half' => $calTypeHalf, 'cal_year' => $cYear, 'mon' => $mon, 'tue' => $tue, 'wed' => $wed, 'thurs' => $thurs, 'fri' => $fri, 'sat' => $sat, 'sun' => $sun,
                                 'max_hours' => $max_hours, 'min_hours' => $min_hours, 'half_max_hours' => $half_max, 'dateModified' => date('Y-m-d H:i:s'));
            $updateStatus = $this->db2->table('hr_calendar_config')->where('id', $id)->update($updateArray);
            return Redirect::to('config/calendar/calendar-list')->with('successalert', 'Calendar updated successfully');
        }
        return View::make('settings.calendar.editCalendar')->with(array('id' => $id, 'cal' => $getCalInfo));
    }

    public function deleteCalendar() {
        $id = Request::Segment(4);
        //$checkStatus = DB::select(DB::raw('select count(id) as emp_count from hr_emp_job_info where calendar='.$id));
        //if($checkStatus[0]->emp_count == 0) {
        $delete = $this->db2->table('hr_calendar_config')->where('id', '=', $id)->delete();
        if ($delete)
            return Redirect::to('config/calendar/calendar-list')->with(array('successalert' => 'Calendar Deleted Successfully'));
        else
            return Redirect::to('config/calendar/calendar-list')->with(array('erroralert' => 'Server problem Try again'));
        // } else {
        // return Redirect::to('calendar/calendar-list')->with(array('erroralert' => 'Calendar already assigned so it cannot be deleted'));
        //}
    }

    public function viewcalendar() {
        $calId = Request::Segment(4);
        $pholiday = array();
        $choliday = array();
        $getCal = $this->db2->table('hr_calendar_config')->select('id', 'cal_name', 'cal_type', 'cal_type_half', 'cal_year', 'mon', 'tue', 'wed', 'thurs', 'fri', 'sat', 'sun', 'alt_holiday')->where('id', $calId)->first();
        $getAltHoliday = $this->db2->table('hr_alternate_holiday as altholy')->join('hr_holiday as h', 'h.id', '=', 'altholy.fkHolyId')->select('altholy.fkHolyId', 'altholy.holiday_date', 'h.holiday_type')->where('altholy.fkCal_Id', $calId)->get();
        //$getAltHoliday = $this->db2->table('hr_assign_alt_holiday as asCal')->join('hr_alternate_holiday as altholy','altholy.id','=','asCal.fkAltHolyId')->join('hr_holiday as h','h.id','=','altholy.fkHolyId')->select('altholy.fkHolyId','altholy.holiday_date','h.holiday_type')->where('asCal.fkCalId',$calId)->get();
        $getHoliday = $this->db2->table('hr_holiday')->select('holiday_date', 'holiday_type');
        if (!empty($getAltHoliday)) {
            foreach ($getAltHoliday as $alt) {
                $getId[] = $alt->fkHolyId;
                if ($alt->holiday_type == 1) // public holiday
                    $pholiday[] = $alt->holiday_date;
                else                       // conpany holiday
                    $choliday[] = $alt->holiday_date;
            }
            $getHoliday = $getHoliday->whereNotIn('id', $getId)->get();
        } else {
            $getHoliday = $getHoliday->get();
        }
        if (!empty($getHoliday)) {
            foreach ($getHoliday as $hd) {
                if ($hd->holiday_type == 1) // public holiday
                    $pholiday[] = $hd->holiday_date;
                else                       // conpany holiday
                    $choliday[] = $hd->holiday_date;
            }
        }
        $getOfferDay = array($getCal->sun, $getCal->mon, $getCal->tue, $getCal->wed, $getCal->thurs, $getCal->fri, $getCal->sat);
        return View::make('settings.calendar.viewCalendar')->with(array('calView' => $getCal, 'woffer' => $getOfferDay, 'p_holiday' => $pholiday, 'c_holiday' => $choliday, 'id' => $calId));
    }

    public function assignAltHolidaycalendar() {
        $getCal = $this->db2->table('hr_calendar_config')->select('id', 'cal_name')->get();
        $getAltHoliday = $this->db2->table('hr_alternate_holiday')->select('id', 'holiday_name', 'holiday_date')->get();
        $postData = Input::all();
        $calId = Input::get('fkCalId');
        $altHolyId = Input::get('fkAltHolyId');
        if (!empty($postData)) {
            $getDtls = $this->db2->table('hr_assign_alt_holiday')->select('id')->where('fkCalId', $calId)->where('fkAltHolyId', $altHolyId)->get();
            if (empty($getDtls)) {
                $insertStatus = $this->db2->table('hr_assign_alt_holiday')->insert($postData);
                if ($insertStatus)
                    $this->db2->table('hr_calendar_config')->where('id', $calId)->update(array('alt_holiday' => 1));
                return Redirect::to('config/calendar/assign-alt-holiday-list')->with(array('successalert', 'Alternate Holiday already assigned to this calendar'));
            } else {
                return Redirect::to('config/calendar/assign-alt-holiday-list')->with(array('warningalert', 'Alternate Holiday already assigned to this calendar'));
            }
        }
        return View::make('settings.calendar.assignAltHolyCalendar')->with(array('cal_list' => $getCal, 'alt_holiday' => $getAltHoliday));
    }

    public function assignedCalendarList() {
        $getCalInfo = $this->db2->table('hr_assign_alt_holiday as assholy')->join('hr_alternate_holiday as altHoly', 'altHoly.id', '=', 'assholy.fkAltHolyId')->join('hr_calendar_config as calConfig', 'calConfig.id', '=', 'assholy.fkCalId')->join('hr_holiday as h', 'h.id', '=', 'altHoly.fkHolyId')->select('assholy.id as assign_id', 'altHoly.holiday_name', 'altHoly.holiday_date', 'calConfig.cal_name', 'calConfig.cal_type', 'h.holiday_name as actual_holiday_name', 'h.holiday_date as actual_holiday_date', 'h.holiday_type')->get();
        return View::make('settings.calendar.assignedCalendarList')->with(array('calList' => $getCalInfo));
    }

    public function deleteAssignHoliday() {
        $id = Request::Segment(4);
        $delStatus = $this->db2->table('hr_assign_alt_holiday')->where('id', $id)->delete();
        if ($delStatus)
            return Redirect::to('config/calendar/assign-alt-holiday-list')->with('successalert', 'Assigned Holiday deleted successfully');
        else
            return Redirect::to('config/calendar/assign-alt-holiday-list')->with('erroralert', 'Sorry Server problem try again');
    }

    public function editAssignAltHoliday() {
        $id = Request::Segment(4);
        $getCal = $this->db2->table('hr_calendar_config')->select('id', 'cal_name')->get();
        $getAltHoliday = $this->db2->table('hr_alternate_holiday')->select('id', 'holiday_name', 'holiday_date')->get();
        $getInfo = $this->db2->table('hr_assign_alt_holiday')->select('fkCalId', 'fkAltHolyId')->where('id', $id)->first();
        $postData = Input::all();
        $calId = Input::get('fkCalId');
        $altHolyId = Input::get('fkAltHolyId');
        if (!empty($postData)) {
            $postData['dateModified'] = date('Y-m-d H:i:s');
            $updateStatus = $this->db2->table('hr_assign_alt_holiday')->where('id', $id)->update($postData);
            return Redirect::to('config/calendar/assign-alt-holiday-list')->with('successalert', 'Alternate Holiday updated successfully');
        }
        return View::make('settings.calendar.editAssignHoliday')->with(array('id' => $id, 'aView' => $getInfo, 'cal_list' => $getCal, 'alt_holiday' => $getAltHoliday));
    }

    public function holidayList1() {
        $holidayList = $this->db2->table('hr_holiday')->select('id', 'holiday_name', 'holiday_type', 'holiday_date')->orderby('holiday_date', 'desc')->get();
        return View::make('settings.calanderLeave.holidayList')->with(array('holiday_list' => $holidayList));
    }

//holiday upload
   public function holidayList() {
        if (isset($_POST['stage']) == 1) {
          if ($_FILES['file1']['error'] > 0) {
                return Redirect::to('config/leave/holiday-list')->with(array('erroralert' => 'Please Upload the file, once again.'));
            }
            $ical = new Icalendar();

            $filename = $_FILES['file1']['tmp_name'];
            $ical->parse("$filename");
            $ical_data = $ical->get_all_data();

            if (function_exists('date_default_timezone_set'))
                date_default_timezone_set("Asia/Kolkata");
            if (!empty($ical_data['VEVENT'])) {

                $save = false;
                foreach ($ical_data['VEVENT'] as $key => $data) {

                    //get StartDate And StartTime
                    $start_dttimearr = explode('T', $data['DTSTART']);
                    $StartDate = $start_dttimearr[0];
                    //$startTime = $start_dttimearr[1];
                    $startTime[$start_dttimearr[0]] = isset($start_dttimearr[1]) ? $start_dttimearr[1] : null;

                    //get EndDate And EndTime
                    $end_dttimearr = explode('T', $data['DTEND']);
                    $EndDate = $end_dttimearr[0];
                    //$EndTime = $end_dttimearr[1];
                    $EndTime[$end_dttimearr[0]] = isset($end_dttimearr[1]) ? $end_dttimearr[1] : null;

                     $datetime1 = strtotime(date('d-m-Y', strtotime($StartDate)));
                    $datetime2 = strtotime(date('d-m-Y', strtotime($EndDate)));
                    $datediff = $datetime2 - $datetime1;
                    $total_days = floor($datediff / (60 * 60 * 24));

                    for ($i = 0; $i < $total_days; $i++) {
                        if ($total_days != 1) {        
                            if ($i == 1) {                       
                                $StartDate = date('Ymd',strtotime("+1 day", strtotime($StartDate)));
                            }                      
                        }



  $if_exits = $this->db2->table('hr_holiday')->where('holiday_date', '=', $StartDate)->get();
                    $insert_query = '';
                    if (!($if_exits)) {
                        $save = true;
                        $insert_query = $this->db2->table('hr_holiday')
                                ->insert(array('holiday_date' => $StartDate, 'holiday_name' => $data['SUMMARY'], 'holiday_type' => '1'));
                    }
}
                }
                if ($save) {
                    return Redirect::to('config/leave/holiday-list')->with(array('successalert' => 'Holiday uploaded Successfully'));
                } else {
                    return Redirect::to('config/leave/holiday-list')->with(array('erroralert' => 'Record Already Exists.'));
                }
            }
        }
        $holidayList = $this->db2->table('hr_holiday')->select('id', 'holiday_name', 'holiday_type', 'holiday_date')->orderby('holiday_date', 'desc')->get();

        return View::make('settings.calanderLeave.holidayList')->with(array('holiday_list' => $holidayList, 'successalert' => 'Holiday delete Successfully'));
    }


//holiday upload finished
    public function addHoliday() {
        $postData = Input::all();
        if (!empty($postData)) {
            $holiday_name = Input::get('holiday_name');
            $holiday_date = date('Y-m-d', strtotime(Input::get('holiday_date')));
            $holiday_date = date('Y-m-d', strtotime($holiday_date));
            $holiday_type = Input::get('holiday_type');
            $insert = $this->db2->table('hr_holiday')->insertGetId(array('holiday_name' => $holiday_name, 'holiday_type' => $holiday_type, 'holiday_date' => $holiday_date));
            if ($insert)
                return Redirect::to('config/leave/edit-holiday/' . $insert)->with(array('successalert' => 'Holiday added Successfully'));
            else
                return Redirect::to('config/leave/holiday-list')->with(array('erroralert' => 'Server problem Try again'));
        }
        return View::make('settings.calanderLeave.addHoliday');
    }

    public function editHoliday() {
        $id = Request::Segment(4);
        $getHoliday = $this->db2->table('hr_holiday')->select('holiday_name', 'holiday_type', 'holiday_date')->where('id', $id)->first();
        $postData = Input::all();
        if (!empty($postData)) {
            $holiday_name = Input::get('holiday_name');
            $holiday_date = Input::get('holiday_date');
            $holiday_date = date('Y-m-d', strtotime($holiday_date));
            $holiday_type = Input::get('holiday_type');
            $currentDate = date('Y-m-d H:i:s', strtotime('now'));
            $update = $this->db2->table('hr_holiday')->where('id', $id)->update(array('holiday_name' => $holiday_name, 'holiday_type' => $holiday_type, 'holiday_date' => $holiday_date, 'dateModified' => $currentDate));
            if ($update)
                return Redirect::to('config/leave/holiday-list')->with(array('successalert' => 'Holiday update Successfully'));
            else
                return Redirect::to('config/leave/holiday-list')->with(array('erroralert' => 'Server problem Try again'));
        }
        $alter_holiday = $this->db2->table('hr_alternate_holiday as t1')
                ->leftJoin('hr_calendar_config as t2', 't2.id', '=', 't1.fkCal_Id')
                ->select('t1.id', 't1.holiday_name', 't1.holiday_date', 't2.cal_name')
                ->where('t1.fkHolyId', $id)
                ->get();
        return View::make('settings.calanderLeave.editHoliday')->with(array('view_holiday' => $getHoliday, 'id' => $id, 'alter_holiday' => $alter_holiday));
    }

    public function deleteHoliday() {
        $id = Request::Segment(4);
        $delete = $this->db2->table('hr_holiday')->where('id', '=', $id)->delete();
        if ($delete)
            return Redirect::to('config/leave/holiday-list')->with(array('successalert' => 'Holiday delete Successfully'));
        else
            return Redirect::to('config/leave/holiday-list')->with(array('erroralert' => 'Server problem Try again'));
    }

    public function addAltHoliday($id) {
        $postData = Input::all();
        if (!empty($postData)) {
            $holyId = $id;
            $cal_id = $postData['cal_id'];
            $holy_name = $postData['holiday_name'];
            $holy_date = date('Y-m-d', strtotime($postData['holiday_date']));
            $insertStatus = $this->db2->table('hr_alternate_holiday')->insert(array('fkHolyId' => $holyId, 'fkCal_Id' => $cal_id, 'holiday_name' => $holy_name, 'holiday_date' => $holy_date));
            if ($insertStatus) {
                return Redirect::to('config/leave/edit-holiday/' . $id)->with('successalert', 'Alternate Holiday added Successfully');
            }
        }
        //$holidayList = $this->db2->table('hr_holiday')->select('id','holiday_name','holiday_date')->get();
        $calender = $this->db2->table('hr_calendar_config')->select('id', 'cal_name')->get();
        return View::make('settings.calanderLeave.addAltHoliday')->with(array('calender' => $calender));
    }

    public function editAltHoliday($hid, $id) {
        //$id = Request::Segment(4);
        $postData = Input::all();
        if (!empty($postData)) {
            $holiday_date = date('Y-m-d', strtotime($postData['holiday_date']));
            $update_array = array('fkHolyId' => $hid,
                'fkCal_Id' => $postData['cal_id'],
                'holiday_name' => $postData['holiday_name'],
                'holiday_date' => $holiday_date,
                'dateModified' => date('d-m-Y H:i:s')
            );
            $updateStatus = $this->db2->table('hr_alternate_holiday')->where('id', $id)->update($update_array);
            if ($updateStatus)
                return Redirect::to('config/leave/edit-holiday/' . $hid)->with('successalert', 'Alternate Holiday updated Successfully');
        }
        $getAltLeave = $this->db2->table('hr_alternate_holiday')->select('id as alt_id', 'fkCal_Id', 'holiday_name', 'holiday_date')->where('id', $id)->first();
        $calender = $this->db2->table('hr_calendar_config')->select('id', 'cal_name')->get();
        return View::make('settings.calanderLeave.editAltHoliday')->with(array('calender' => $calender, 'id' => $id, 'lview' => $getAltLeave));
    }

    public function deleteAltHoliday($hid, $id) {
        //$id = Request::Segment(4);
        $delete = $this->db2->table('hr_alternate_holiday')->where('id', '=', $id)->delete();
        if ($delete)
            return Redirect::to('config/leave/edit-holiday/' . $hid)->with(array('successalert' => 'Holiday Delete Successfully'));
        else
            return Redirect::to('config/leave/edit-holiday/' . $hid)->with(array('erroralert' => 'Server problem Try again'));
    }

    public function altHolidayList() {
        $selAltLeave = $this->db2->table('hr_alternate_holiday as alt_hol')->join('hr_holiday as hol', 'hol.id', '=', 'alt_hol.fkHolyId')->select('alt_hol.id as alt_id', 'alt_hol.holiday_name as alt_holiday_name', 'alt_hol.holiday_date as alt_holiday_date', 'hol.holiday_name', 'hol.holiday_date')->get();
        return View::make('settings.calanderLeave.altHolidayListing')->with(array('alt_leave' => $selAltLeave));
    }

    public function deleteEmployementCategory() {
        $id = Request::Segment(3);
        $checkStatus = $this->db2->select($this->db2->raw('select count(id) as emp_count from hr_emp_job_status where fkEmpStatus_id=' . $id));
        if ($checkStatus[0]->emp_count == 0) {
            $delete = $this->db2->table('hr_employement_category')->where('id', '=', $id)->delete();
            if ($delete)
                return Redirect::to('config/employement_category')->with(array('successalert' => 'Category Deleted Successfully'));
            else
                return Redirect::to('config/employement_category')->with(array('erroralert' => 'Server problem Try again'));
        } else {
            return Redirect::to('config/employement_category')->with(array('erroralert' => 'Employment Status already assigned so it cannot be deleted'));
        }
    }

    /*
     * Purpose : Edit Company Profile
     * Return Boolean value
     */

    public function editCompanyProfile() {
        $id = Session::has('proxy_cpy_id') ? Session::get('proxy_cpy_id') : Session::get('cpy_id');
        $postData = Input::all();
        if (!empty($postData)) {
            if ($postData['logo']) {
                $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'gif', 'GIF');
                $file = Input::file('logo');
                $extension = $file->getClientOriginalExtension();
                $fname = $file->getClientOriginalName();
                if (!in_array($extension, $allowed)) {
                    return Redirect::back()->withInput()->with('erroralert', 'Please upload valid file.');
                }
            }
            if (empty($postData['forgot_status'])) {
                $postData['forgot_status'] = '1';
            }
            $updateArray = array('company_name' => $postData['cpy_name'],
                'company_uen' => $postData['cpy_uen'],
                'telephone' => $postData['ph_no'],
                'fax_no' => $postData['fax_no'],
                'Industry' => $postData['Industry'],
                'e_year' => $postData['e_year'],
                'bank_name' => $postData['bank_name'],
                'bank_acc_no' => $postData['bank_acc_no'],
                'payment_type' => $postData['payment_type'],
                'cpf_sub' => $postData['cpf_sub'],
                'cpf_pay' => $postData['cpf_pay'],
                'cpf_sno' => $postData['cpf_sno'],
                'business_address' => $postData['business_address']
                    //'forgot_pstatus' => $postData['forgot_status'],
                    //'block_no'     => $postData['block_hse_no'],
                    //'street_name'  => $postData['street_name'],
                    //'level'        => $postData['level'],
                    //'unit_no'      => $postData['unit_no'],
                    //'city'         => $postData['city'],
                    //'state'        => $postData['state'],
                    //'country'      => $postData['country']
            );
            $updateStatus = DB::table('hr_company_dtls')->where('id', $id)->update($updateArray);
            if ($postData['logo']) {
                $updateimage = DB::table('hr_company_dtls')->where('id', $id)->update(array('logo' => $extension));
                $filename = $id . '.' . $file->getClientOriginalExtension();
                $cpath = 'public/company_info/' . $id;
                if (!file_exists($cpath)) {
                    mkdir($cpath, 0755);
                }
                $path = 'public/company_info/' . $id . '/logo';
                if (!file_exists($path)) {
                    mkdir($path, 0755);
                }
                $files_path = 'public/company_info/' . $id . '/logo';
                $destinationPath = $files_path;

                $img = Image::make($file);
                $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($destinationPath . '/' . $filename);
            }
            // if(!empty($updateStatus)){
            return Redirect::to('config/edit-account-register')->with('successalert', 'Company account updated successfully');
            //} 
        }
        $cpyDtls = DB::table('hr_company_dtls')->where('id', $id)->first();
        return View::make('settings.company.companyProfile')->with(array('cpy' => $cpyDtls));
    }

    /* Purpose : Add user
     * Return Boolean value
     */

    public function addUser($id = '') {

        $postData = Input::all();
        if (!empty($postData)) {
            $pass = Input::get('password');
            $confirm_pass = Input::get('confirm_password');
            if ($pass == $confirm_pass) {
                $username = trim(Input::get('username'));
                $user_result = DB::table('hr_login_credentials')->select('username')->where('username', '=', $username)->get();
                if ($user_result) {
                    return Redirect::back()->with('erroralert', 'Username already exist.Please try with different username.')->withInput(Input::except('password'), Input::except('confirm_password'));
                } else {
                    if (Input::has('company_name')) {
                        $createdBy = 2;
                    } else {
                        $createdBy = 1;
                    }

                    $input_array = array('fkCompany_id' => trim(Input::get('company')), 'username' => Input::get('username'), 'password' => md5(Input::get('password')), 'account_type' => Input::get('ac_type'), 'created_by' => $createdBy);
                    $result = DB::table('hr_login_credentials')->insert($input_array);

                    if (!Input::has('company_name')) {
                        return Redirect::to('config/company-user-settings')->with('successalert', 'User added Successfully');
                    } else {

                        return Redirect::to('config/company-user-settings')->with('successalert', 'User added Successfully');
                    }
                }
            } else {
                return Redirect::back()->with('erroralert', 'Passwords should match.')->withInput(Input::except('password'), Input::except('confirm_password'));
            }
        }
        $companies = DB::table('hr_company_dtls as cmp')->select('id', 'company_name')->where(array('is_active' => 1, 'delete_status' => 0))->get();
        return View::make('settings.company.addUser')->with('company', $companies);
    }

    /* Purpose : Edit Cuser
     * Return Boolean value
     */
	
     public function editUser($id) {
        $postData = Input::all();
$user_permission = '';
        if (!empty($postData)) {

            $username = trim(Input::get('username'));
            $user_result = DB::table('hr_login_credentials')->select('username')->where('username', '=', $username)->where('id', "!=", $id)->get();
            if ($user_result) {
                return Redirect::back()->with('erroralert', 'Username already exist.Please try with different username.');
            } else {
                if (Input::has('password_change')) {
                    $user_pass = md5(trim(Input::get('old_password')));
                    $password = DB::table('hr_login_credentials')->select('password')->where('id', "=", $id)->first();

                    if ($password->password == $user_pass) {

                        $pass_update = DB::table('hr_login_credentials')->where('id', "=", $id)->update(array('password' => md5(Input::get('new_password'))));
                    } else {
                        return Redirect::back()->with('erroralert', 'Old password did not match.');
                    }
                }
			
			
				$permission = isset($postData['check']) ? 1 : 2 ;

                if (Input::has('company_name')) {
                    $updatedBy = 2;
                } else {
                    $updatedBy = 1;
                }
                if (Input::has('ac_type')) {
                    $acct_types = Input::get('ac_type');
                } else {
                    $acct_types = Input::get('hidden_account_type');
                }
if (isset($postData['permission'])) {
                    $user_permission = serialize($postData['permission']);
                }

                if (!Input::has('company_name')) {
                    $update_array = array('fkCompany_id' => Input::get('company'), 'username' => Input::get('username'), 'muliple_option' => isset($postData['muliple_option']) ? $postData['muliple_option'] : 0, 'account_type' => $acct_types, 'updated_by' => $updatedBy ,'permission'=>$permission, 'user_permission' => $user_permission);
                } else {
                    $update_array = array('username' => Input::get('username'), 'account_type' => $acct_types, 'muliple_option' => $postData['muliple_option'], 'updated_by' => $updatedBy,'permission'=>$permission, 'user_permission' => $user_permission);
                }


                $result = DB::table('hr_login_credentials')->where('id', '=', $id)->update($update_array);
                $getUserDetails = DB::table('hr_login_credentials as t1')
                        ->join('hr_company_database as t2', 't2.fkCompany_id', '=', 't1.fkCompany_id')
                        ->select('t2.host_address', 't2.db_name', 't2.user_name', 't2.password', 't1.fkUserId')
                        ->where('t1.id', $id)
                        ->first();

                $this->db2->table('hr_emp_info')->where('id', $getUserDetails->fkUserId)->update(array('email_id' => Input::get('username')));


                if (!Input::has('company_name')) {
                    return Redirect::to('config/company-user-settings')->with('successalert', 'User updated Successfully');
                } else {
                    return Redirect::to('config/company-user-settings')->with('successalert', 'User updated Successfully');
                }
            }
        }


        $companies = DB::table('hr_company_dtls as cmp')->select('id', 'company_name', 'customize_approve')->where(array('is_active' => 1, 'delete_status' => 0))->get();
        $user = DB::table('hr_login_credentials as user')
                        ->join('hr_company_dtls as comp', 'comp.id', "=", 'user.fkCompany_id')
                        ->select('user.id', 'user.username', 'user.password', 'user.muliple_option', 'user.ml_settings','user.permission', 'user.account_type', 'comp.id as comp_id')->where('account_status', 1)->where('user.id', '=', $id)->get();

        $role = array(1, 2, 3, 4, 5);
        $role_type = Session::has('proxy_user_role') ? Session::get('proxy_user_role') : Session::get('user_role');
   $user_permission = DB::table('hr_login_credentials')
                        ->select('user_permission')
                        ->where('account_status', 1)->where('id', '=', $id)->first();
        if ($user_permission) {
            $user_permission = unserialize($user_permission->user_permission);
        }
        $cmpny_Id = Session::has('proxy_cpy_id') ? Session::get('proxy_cpy_id') : Session::get('cpy_id');
        $users = DB::table('hr_login_credentials')->select('fkUserId as uid')->whereIn('account_type', $role)->where('account_status', 1)->where('fkCompany_id', $cmpny_Id)->orderBy('fkUserId')->get();

        $auth = array();
        if (!empty($users)) {
            foreach ($users as $u) {
                if ($u->uid != 0) {
                    $auth[] = $u->uid;
                }
            }
        }

        if (in_array($role_type, $role)) {
            if ($auth) {
                $reportTo = $this->db2->table('hr_emp_info')->select('hr_emp_info.id', 'hr_emp_info.first_name', 'hr_emp_info.last_name')->whereIn('id', $auth)->where('local_del', 0)->get();
            } else {
                $reportTo = '';
            }
        } else {
            $reportTo = $this->db2->table('hr_emp_info')->select('hr_emp_info.id', 'hr_emp_info.first_name', 'hr_emp_info.last_name')->where('id', '!=', $id)->whereIn('id', $auth)->where('local_del', 0)->get();
        }
		$approve = $this->db2->table('hr_multi_approve')->select('approve_module')->orderBy('sort_order')->get();

        return View::make('settings.company.editUser')->with(array('user' => $user, 'company' => $companies, 'report' => $reportTo, 'multi'=>$approve, 'user_permission' => $user_permission));
        //return View::make('settings.company.editUser')->with(array('company' => $companies, 'user' => $user));
    }
  public function multiApprove() {


        $postData = Input::all();
        $data[] = '';
        $cmpny_Id = Session::has('proxy_cpy_id') ? Session::get('proxy_cpy_id') : Session::get('cpy_id');
        $com_name = Session::get('proxy_cpy_name') ? Session::get('proxy_cpy_name') : Session::get('cpy_name');

        if ($postData) {

            $limit1 = Input::get("limit1");
            $limit2 = Input::get("limit2");
            $limit3 = Input::get("limit3");
            $limit4 = Input::get("limit4");


            if (!empty($limit1)) {
                $level_count = count($limit1);
                /* To delete */
                $level_exist_count = $this->db2->table('hr_multi_approve')
                                ->select(DB::raw('count(*) as exist_count'))
                                ->where('approve_module', '=', 1)->first();
                if (isset($level_exist_count) && $level_exist_count->exist_count != $level_count) {
                    $fund_range_delete = $this->db2->table('hr_multi_approve')->where('approve_module', '=', 1)
                            ->where('level', '>', $level_count)
                            ->delete();
                }
                $level = 1;
                for ($i = 0; $i < count($limit1); $i++) {
                    $data = $this->db2->table('hr_multi_approve')->where('approve_module', '=', 1)
                                    ->Where('level', '=', $level)->first();
                    if ($data) {
                        /* Update level */
                        $update = $this->db2->table('hr_multi_approve')
                                ->where('approve_module', '=', 1)
                                ->Where('level', '=', $level)
                                ->update(['limit' => isset($limit1[$i]) ? $limit1[$i] : 0,
                            'sort_order' => $level
                        ]);
                    } else {
                        $insert_val = $this->db2->table('hr_multi_approve')
                                ->insert(array('limit' => isset($limit1[$i]) ? $limit1[$i] : 0,
                            'sort_order' => $level, 'approve_module' => 1,
                            'level' => $level,
                            'created_at' => date('y-m-d')));
                    }
                    $level++;
                }
				 return Redirect::back()->with('successalert', 'Settings updated Successfully');
            }

            if (!empty($limit2)) {
                $level_count = count($limit2);
                /* To delete */
                $level_exist_count = $this->db2->table('hr_multi_approve')
                                ->select(DB::raw('count(*) as exist_count'))
                                ->where('approve_module', '=', 2)->first();
                if (isset($level_exist_count) && $level_exist_count->exist_count != $level_count) {
                    $fund_range_delete = $this->db2->table('hr_multi_approve')->where('approve_module', '=', 2)
                            ->where('level', '>', $level_count)
                            ->delete();
                }
                $level = 1;
                for ($i = 0; $i < count($limit2); $i++) {
                    $data = $this->db2->table('hr_multi_approve')->where('approve_module', '=', 2)
                                    ->Where('level', '=', $level)->first();
                    if ($data) {
                        /* Update level */
                        $update = $this->db2->table('hr_multi_approve')
                                ->where('approve_module', '=', 2)
                                ->Where('level', '=', $level)
                                ->update(['limit' => isset($limit2[$i]) ? $limit2[$i] : 0,
                            'sort_order' => $level
                        ]);
                    } else {
                        $insert_val = $this->db2->table('hr_multi_approve')
                                ->insert(array('limit' => isset($limit2[$i]) ? $limit2[$i] : 0,
                            'sort_order' => $level, 'approve_module' => 2,
                            'level' => $level,
                            'created_at' => date('y-m-d')));
                    }
                    $level++;
                }
				 return Redirect::back()->with('successalert', 'Settings updated Successfully');
            }

            if (!empty($limit3)) {
                $level_count = count($limit3);
                /* To delete */
                $level_exist_count = $this->db2->table('hr_multi_approve')
                                ->select(DB::raw('count(*) as exist_count'))
                                ->where('approve_module', '=', 3)->first();
                if (isset($level_exist_count) && $level_exist_count->exist_count != $level_count) {
                    $fund_range_delete = $this->db2->table('hr_multi_approve')->where('approve_module', '=', 3)
                            ->where('level', '>', $level_count)
                            ->delete();
                }
                $level = 1;
                for ($i = 0; $i < count($limit3); $i++) {
                    $data = $this->db2->table('hr_multi_approve')->where('approve_module', '=', 3)
                                    ->Where('level', '=', $level)->first();
                    if ($data) {
                        /* Update level */
                        $update = $this->db2->table('hr_multi_approve')
                                ->where('approve_module', '=', 3)
                                ->Where('level', '=', $level)
                                ->update(['limit' => isset($limit3[$i]) ? $limit3[$i] : 0,
                            'sort_order' => $level
                        ]);
                    } else {
                        $insert_val = $this->db2->table('hr_multi_approve')
                                ->insert(array('limit' => isset($limit3[$i]) ? $limit3[$i] : 0,
                            'sort_order' => $level, 'approve_module' => 3,
                            'level' => $level,
                            'created_at' => date('y-m-d')));
                    }
                    $level++;
                }
				 return Redirect::back()->with('successalert', 'Settings updated Successfully');
            }

            if (!empty($limit4)) {
                $level_count = count($limit4);
                /* To delete */
                $level_exist_count = $this->db2->table('hr_multi_approve')
                                ->select(DB::raw('count(*) as exist_count'))
                                ->where('approve_module', '=', 4)->first();
                if (isset($level_exist_count) && $level_exist_count->exist_count != $level_count) {
                    $fund_range_delete = $this->db2->table('hr_multi_approve')->where('approve_module', '=', 4)
                            ->where('level', '>', $level_count)
                            ->delete();
                }
                $level = 1;
                for ($i = 0; $i < count($limit4); $i++) {
                    $data = $this->db2->table('hr_multi_approve')->where('approve_module', '=', 4)
                                    ->Where('level', '=', $level)->first();
                    if ($data) {
                        /* Update level */
                        $update = $this->db2->table('hr_multi_approve')
                                ->where('approve_module', '=', 4)
                                ->Where('level', '=', $level)
                                ->update(['limit' => isset($limit4[$i]) ? $limit4[$i] : 0,
                            'sort_order' => $level
                        ]);
                    } else {
                        $insert_val = $this->db2->table('hr_multi_approve')
                                ->insert(array('limit' => isset($limit4[$i]) ? $limit4[$i] : 0,
                            'sort_order' => $level, 'approve_module' => 4,
                            'level' => $level,
                            'created_at' => date('y-m-d')));
                    }
                    $level++;
                }
				 return Redirect::back()->with('successalert', 'Settings updated Successfully');
            }
            $multi_setting = array('ml_settings' => isset($postData['multi']) ? $postData['multi'] : 0);
            $insert_val = DB::table('hr_login_credentials')->where('fkCompany_id', $cmpny_Id)->update($multi_setting);

//            if ($insert_val) {
                //return Redirect::to('config/company/multi-approve')->with('successalert', 'Settings updated Successfully');
//            } else {
        //    return Redirect::to('config/company/multi-approve')->with('erroralert', 'Sorry updated Failed');
//            }
        }

        $multi = DB::table('hr_login_credentials')->select('ml_settings')->where('fkCompany_id', $cmpny_Id)->get();

        $approve = $this->db2->table('hr_multi_approve')->orderBy('sort_order')->get();
//print_r($approve);die;

        return View::make('settings.company.editApprove')->with(array('approve' => $approve, 'multi' => $multi));
    }

	 public function editApprove($id) {
	 
            $postData = Input::all();
			$data[] = '';
       
            $com_name = Session::get('proxy_cpy_name') ? Session::get('proxy_cpy_name') : Session::get('cpy_name');
  
          
			if ($postData) {
				$level = Input::get("level");
				$limit = Input::get("limit");
				$sort = Input::get("sort");
				if($postData['approve']==2){ $type=2;}
				else if($postData['approve']==1){ $type=1; }
				else if($postData['approve']==3){ $type=3; }
				else if($postData['approve']==4){ $type=4; }
				else { $type=0 ;}
				//$type=1;
				$del_old = $this->db2->table('hr_expense_approve')->where('user_id', $id)->where('approve_module', $type)->delete();
				$j=1;
				for ($i =0; $i <count($level); $i++) {
				
				
					
				//$insert_val=	$this->db2->table('hr_expense_approve')
							//->where('emp_id', $id)
							//->where('approve_module', $type)
							//->where('sort_order',$j)
							//->update(array('level_id' => $level[$i] , 'limit' =>  $limit[$i] ));
				
				$insert_val= $this->db2->table('hr_expense_approve')->insert(array('level_id' => isset($level[$i]) ? $level[$i] : 0, 'limit' => isset($limit[$i]) ? $limit[$i] : 0, 'sort_order' => $j, 'approve_module' => $type, 'emp_id'=>$postData['emp_id'] , 'company_id' =>$postData['cmpny_id'] , 'created_at' => date('y-m-d'),'user_id'=>$postData['userid']));
					//$update_username = $this->db2->table('hr_expense_approve')->where('approve_module', $type)
																			 // ->where('level', $j)
																			 // ->update(array('approver_type' => isset($level[$i]) ? $level[$i] : 0, 'limit' => isset($limit[$i]) ? $limit[$i] : 0));
				
				//$count++;
				$j++;
				//$k++;
				}
				 if ($insert_val==true) {
                    return Redirect::to('config/company/edit-approve/'.$id)->with('successalert', 'User updated Successfully');
                } else {
                    return Redirect::to('config/company-user-settings')->with('erroralert', 'Sorry updated Failed');
                }
		   }
		    
			$details = $this->db2->table('hr_expense_approve')->where('approve_module', 2)->get();
			$companies = DB::table('hr_company_dtls as cmp')->select('id', 'company_name','customize_approve')->where(array('is_active' => 1, 'delete_status' => 0))->get();
			$user = DB::table('hr_login_credentials as user')
							->join('hr_company_dtls as comp', 'comp.id', "=", 'user.fkCompany_id')
							->select('user.id', 'user.username', 'user.password','user.muliple_option', 'user.ml_setting','user.user_read', 'user.user_edit', 'user.user_app', 'user.fkUserId','user.account_type', 'comp.id as comp_id')->where('account_status', 1)->where('user.id', '=', $id)->get();
			$role = array(1, 2, 3, 4, 5);
			$role_type = Session::has('proxy_user_role') ? Session::get('proxy_user_role') : Session::get('user_role');

			$cmpny_Id = Session::has('proxy_cpy_id') ? Session::get('proxy_cpy_id') : Session::get('cpy_id');
			$users = DB::table('hr_login_credentials')->select('fkUserId as uid')->whereIn('account_type', $role)->where('account_status', 1)->where('fkCompany_id', $cmpny_Id)->orderBy('fkUserId')->get();

			$auth = array();
			if (!empty($users)) {
				foreach ($users as $u) {
					if ($u->uid != 0) {
						$auth[] = $u->uid;
					}
				}
			}

			if (in_array($role_type, $role)) {
				$reportTo = $this->db2->table('hr_emp_info')->select('hr_emp_info.id', 'hr_emp_info.first_name', 'hr_emp_info.last_name')->whereIn('id', $auth)->where('local_del', 0)->get();
			} else {
				$reportTo = $this->db2->table('hr_emp_info')->select('hr_emp_info.id', 'hr_emp_info.first_name', 'hr_emp_info.last_name')->where('id', '!=', $id)->whereIn('id', $auth)->where('local_del', 0)->get();
			}					
			$approve=$this->db2->table('hr_expense_approve')->where('user_id', $id)->orderBy('sort_order')->get();
			
        return View::make('settings.company.editApprove', $data )->with(array('details' => $details ,'user' => $user ,'company' => $companies,'report'=>$reportTo,'approve'=>$approve));

      //  return View::make('settings.company.editUser')->with(array('company' => $companies, 'user' => $user));
    }
	
	 public function addApprove($id) {
	 
            $postData = Input::all();

			if (!empty($postData)) {
				$level = Input::get("level");
				$limit = Input::get("limit");
				$sort = Input::get("sort");
				if($postData['approve']==2){ $type=2;}
				else if($postData['approve']==1){ $type=1; }
				else if($postData['approve']==3){ $type=3; }
				else if($postData['approve']==4){ $type=4; }
				else { $type=0 ;}
				//$type=1;
				$j=1;
				for ($i =0; $i <count($level); $i++) {
				$insert_val= $this->db2->table('hr_expense_approve')->insert(array('level_id' => isset($level[$i]) ? $level[$i] : 0, 'limit' => isset($limit[$i]) ? $limit[$i] : 0, 'sort_order' => $j, 'approve_module' => $type, 'emp_id'=>$postData['emp_id'] , 'company_id' =>$postData['cmpny_id'] , 'created_at' => date('y-m-d'),'user_id'=>$postData['userid']));
					//$update_username = $this->db2->table('hr_expense_approve')->where('approve_module', $type)
																			 // ->where('level', $j)
																			 // ->update(array('approver_type' => isset($level[$i]) ? $level[$i] : 0, 'limit' => isset($limit[$i]) ? $limit[$i] : 0));
				
				//$count++;
				$j++;
				//$k++;
				}
				 if ($insert_val==true) {
                    return Redirect::to('config/company/edit-approve/'.$id)->with('successalert', 'User updated Successfully');
                } else {
                    return Redirect::to('config/company-user-settings')->with('erroralert', 'Sorry updated Failed');
                }
		   }
		    
			$details = $this->db2->table('hr_expense_approve')->where('approve_module', 2)->get();
			$companies = DB::table('hr_company_dtls as cmp')->select('id', 'company_name','customize_approve')->where(array('is_active' => 1, 'delete_status' => 0))->get();
			$user = DB::table('hr_login_credentials as user')
							->join('hr_company_dtls as comp', 'comp.id', "=", 'user.fkCompany_id')
							->select('user.id', 'user.username', 'user.password', 'user.user_read', 'user.user_edit', 'user.user_app', 'user.fkUserId','user.account_type', 'comp.id as comp_id')->where('account_status', 1)->where('user.id', '=', $id)->get();
			$role = array(1, 2, 3, 4, 5);
			$role_type = Session::has('proxy_user_role') ? Session::get('proxy_user_role') : Session::get('user_role');

			$cmpny_Id = Session::has('proxy_cpy_id') ? Session::get('proxy_cpy_id') : Session::get('cpy_id');
			$users = DB::table('hr_login_credentials')->select('fkUserId as uid')->whereIn('account_type', $role)->where('account_status', 1)->where('fkCompany_id', $cmpny_Id)->orderBy('fkUserId')->get();

			$auth = array();
			if (!empty($users)) {
				foreach ($users as $u) {
					if ($u->uid != 0) {
						$auth[] = $u->uid;
					}
				}
			}

			if (in_array($role_type, $role)) {
				$reportTo = $this->db2->table('hr_emp_info')->select('hr_emp_info.id', 'hr_emp_info.first_name', 'hr_emp_info.last_name')->whereIn('id', $auth)->where('local_del', 0)->get();
			} else {
				$reportTo = $this->db2->table('hr_emp_info')->select('hr_emp_info.id', 'hr_emp_info.first_name', 'hr_emp_info.last_name')->where('id', '!=', $id)->whereIn('id', $auth)->where('local_del', 0)->get();
			}					
	
			
        return View::make('settings.company.addApprove' )->with(array('details' => $details ,'user' => $user ,'company' => $companies,'report'=>$reportTo));

      
    }

    public function checkEditUen($id) {
        $company_uen = Input::get('cpy_uen');
        $getusername = DB::table('hr_company_dtls')->where('company_uen', $company_uen)->where('id', '!=', $id)->where('is_active','=',1)->select('id')->get();
        if (count($getusername) > 0) {
            echo "false";
        } else {
            echo "true";
        }
        die;
    }

    /*
     * Purpose : leave settings
     * Return Boolean value
     */

    public function leaveSettings() {
        return View::make('settings/leaveSettings');
    }

    /*
      Purpose : ajax get day name
     * Return Boolean value
     */

    public function getDayname($date) {
        $sStartDate = gmdate("Y-m-d", strtotime($date));
             echo $startday = date('l', strtotime($sStartDate)); die;
    }

    /**
     * Notification settings
     */
    public function notification($id) {
        $notify_count = $this->db2->table('hr_notifications as t1')->select('t1.id', 't1.notification', 't1.email_setting')->where('fkEmp_id', $id)->count();
        if ($notify_count == 0) {
            $notify = array('fkEmp_Id' => $id,
                'notification' => 1,
                'email_setting' => 1
            );
            $this->db2->table('hr_notifications')->insert($notify);
        }

        $postData = Input::all();
        if (!empty($postData)) {
            $notify_id = $postData['notify_id'];
            $update = array('notification' => $postData['notify'],
                'email_setting' => $postData['email']
            );
            $result = $this->db2->table('hr_notifications')->where('id', $notify_id)->update($update);
            return Redirect::to('config/notification/' . $id)->with('successalert', 'Notification Settings Updated');
        } else {
            $notification = $this->db2->table('hr_notifications as t1')->select('t1.id', 't1.notification', 't1.email_setting')->where('fkEmp_id', $id)->get();
            return View::make('settings.notification.notification')->with(array('notification' => $notification));
        }
    }

    public function getCalHoliday($calId, $sDate) {
        $off = 0;
        $sStartDate = gmdate("Y-m-d", strtotime($sDate));
        $startday = date('l', strtotime($sStartDate));
        $calender = $this->db2->table('hr_calendar_config')->select('*')->where('id', $calId)->first();
        $calDays = array();
        $calDays['Sunday'] = $calender->sun;
        $calDays['Monday'] = $calender->mon;
        $calDays['Tuesday'] = $calender->tue;
        $calDays['Wednesday'] = $calender->wed;
        $calDays['Thursday'] = $calender->thurs;
        $calDays['Friday'] = $calender->fri;
        $calDays['Saturday'] = $calender->sat;

        if (array_key_exists($startday, $calDays)) {
            $val = $calDays[$startday];
            if ($val == 9) {
                $off = 1;
            }
        }
        return $off;
    }

    public function checkHolidayName() {
        $holidayname = Input::get('holiday_name');
        $getHolidayName = $this->db2->table('hr_holiday')->where('holiday_name', $holidayname)->count();
        if ($getHolidayName > 0) {
            return "false";
        } else {
            return "true";
        }
    }

    public function editCheckHolidayName($id) {
        $holidayname = Input::get('holiday_name');
        $getHolidayName = $this->db2->table('hr_holiday')->where('id', '!=', $id)->where('holiday_name', $holidayname)->count();
        if ($getHolidayName > 0) {
            return "false";
        } else {
            return "true";
        }
    }
    public function chart() {
        $data = [];
        if (Session::get('user_id')) {
            $id = Session::get('user_id');
        } else {
            $id = Session::get('proxy_user_id');
        }
         $data['level1'] = $this->db2->table('hr_emp_info')->select('*')->where('id', $id)->where('local_del', '0')->first();
$data['dep'] = $this->db2->table('hr_emp_job_info')->select('*')->where('fkEmp_id', $id)->where('is_delete', '1')->first();
        return View::make('settings.chart.organizationChart')->with($data);
    }
}
