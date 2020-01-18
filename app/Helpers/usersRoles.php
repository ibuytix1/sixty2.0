<?php

function roles($parm='') {
    $userData = Session::get('user_data');
    $query = DB::table('adsd_permission_role as r');
    $query->join('adsd_permissions as p', 'r.permission_id', '=', 'p.id');
    $query->join('adsd_role_category as c', 'r.role_cat_id', '=', 'c.id');
    $query->select('c.cate_name', 'c.display_name');
    if(!empty($parm)){
        $query->where('c.cate_name', $parm);
    }
    $query->where('r.user_id', $userData['id']);
    $permissions=$query->first();
    
    return $permissions;
}



function permissions($parm=array()) {
    // pr($parm);exit;
    $userData = Session::get('user_data');
    $query = DB::table('adsd_permission_role as r');
    $query->join('adsd_permissions as p', 'r.permission_id', '=', 'p.id');
    $query->join('adsd_role_category as c', 'r.role_cat_id', '=', 'c.id');
    $query->select('p.*');
    if(!empty($parm)){
        $query->where('p.name', $parm[1]);
        $query->where('c.cate_name', $parm[0]);
    }
    $query->where('r.user_id', $userData['id']);
    $permissions=$query->get();
    
    return $permissions;
}




function role_categories(){
    $query = DB::table('adsd_role_category')->select('id', 'cate_name')->get();
    $role_categories = array();
    foreach ($query as $key => $value) {
        $value->permissions = get_permistions();
        
        array_push($role_categories, $value);
    }
    
    return $role_categories;
}



function get_permistions(){
    $permistions = DB::table('adsd_permissions')->select('id','name')->get();
    
    return $permistions;
}





function assigned_permissions($cId, $pId, $uId){
    $perm = DB::table('adsd_permission_role')
                    ->select('id')
                    ->where('role_cat_id', $cId)
                    ->where('permission_id', $pId)
                    ->where('user_id', $uId)
                    ->count();
    $assiged = $perm > 0 ? 'checked' : '';
    return $assiged;
}