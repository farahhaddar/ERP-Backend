<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'AuthController@login');


Route::group(['middleware' => ['jwt.verify']], function() {
//*************************************************************************************//
//                               USER   ROUTES                                         // 
//*************************************************************************************//
Route::get('/users/{rowNb}','UserController@index');
Route::get('/user/{id}','UserController@show');
Route::post('/user','UserController@store');
Route::put('/user/{id}','UserController@update');
Route::delete('/user/{id}','UserController@destroy');
Route::post('/logout', 'AuthController@logout');
Route::get('/users','UserController@count');


//*************************************************************************************//
//                               EMPLOYEES ROUTES                                      // 
//*************************************************************************************//
  
  Route::get('/employees/{rowNb}','EmployeeController@index');
  Route::get('/employee/{id}','EmployeeController@show');
  Route::post('/employee','EmployeeController@store');
  Route::put('/employee/{id}','EmployeeController@update');
  Route::delete('/employee/{id}','EmployeeController@destroy');
  Route::get('/employees','EmployeeController@count');
// Route::resource('employee','EmployeeController'); php artisan route:list to see all routes

//*************************************************************************************//
//                              TEAMS ROUTES                                           // 
//*************************************************************************************// 
   Route::get('/teams/{rowNb}','TeamController@index'); 
   Route::get('/team/{id}','TeamController@show');
   Route::post('/team','TeamController@store');
   Route::put('/team/{id}','TeamController@update'); 
   Route::delete('/team/{id}','TeamController@destroy');
   Route::get('/teams','TeamController@count'); 

//*************************************************************************************//
//                               PROJECTS   ROUTES                                     // 
//*************************************************************************************//

Route::get('/projects/{rowNb}','ProjectController@index'); 
Route::get('/project/{id}','ProjectController@show');
Route::post('/project','ProjectController@store');
Route::put('/project/{id}','ProjectController@update'); 
Route::delete('/project/{id}','ProjectController@destroy');
Route::get('/projects','ProjectController@count'); 

//*************************************************************************************//
//                               Team_Projects ROUTES                                            // 
//*************************************************************************************//

Route::get('/teamProjects/{rowNb}','TeamProjectController@index'); 
Route::get('/teamProject/{id}','TeamProjectController@show');
Route::get('/teamProjectAssigned/{id}','TeamProjectController@teamProjectAssigned');
Route::get('/teamsNotAssigned','TeamProjectController@teamsNotAssigned');

Route::post('/teamProject','TeamProjectController@store');
Route::put('/teamProject/{id}','TeamProjectController@update'); 
Route::delete('/teamProject/{projectId}/{teamId}','TeamProjectController@destroy');

//*************************************************************************************//
//                               Role ROUTES                                            // 
//*************************************************************************************//

Route::get('/roles/{rowNb}','RoleController@index'); 
Route::get('/role/{id}','RoleController@show');
Route::post('/role','RoleController@store');
Route::put('/role/{id}','RoleController@update'); 
Route::delete('/role/{id}','RoleController@destroy');
Route::get('/roles','RoleController@count'); 

//*************************************************************************************//
//                         EMPLOYEE_TEAM_ROLES ROUTES                                  // 
//*************************************************************************************//
Route::get('/employeeProjectRoles/{rowNb}','EmployeeProjectRoleController@index'); 
Route::get('/employeeProjectRole/{id}','EmployeeProjectRoleController@show');
Route::get('/employeeProjectRoleNotAssigned','EmployeeProjectRoleController@notAssigned');
Route::get('/employeesProjectsRoles/{rowNb}','EmployeeProjectRoleController@employees');
Route::get('/projectRole/{id}/{rowNb}','EmployeeProjectRoleController@projectRole');
Route::post('/employeeProjectRole','EmployeeProjectRoleController@store');
Route::put('/employeeProjectRole/{id}','EmployeeProjectRoleController@update'); 
Route::put('/updateRole','EmployeeProjectRoleController@updateRole'); 
Route::delete('/employeeProjectRole/{id}/{id2}','EmployeeProjectRoleController@destroy');

//*************************************************************************************//
//                               kPI ROUTES                                            // 
//*************************************************************************************//

Route::get('/kpis/{rowNb}','KpiController@index'); 
Route::get('/kpi/{id}','KpiController@show');
Route::get('/kpiCurrent/{rowNb}','KpiController@kpiCurrent');
Route::post('/kpi','KpiController@store');
Route::put('/kpi/{id}','KpiController@update'); 
Route::delete('/kpi/{id}','KpiController@destroy');
Route::get('/kpis','KpiController@count'); 

//*************************************************************************************//
//                               kPI_DETAILS ROUTES                                    // 
//*************************************************************************************//

Route::get('/kpisd/{rowNb}','KpiDetailController@index'); 
Route::get('/kpid/{id}','KpiDetailController@show');
Route::post('/kpid','KpiDetailController@store');
Route::put('/kpid/{id}','KpiDetailController@update'); 
Route::delete('/kpid/{id}','KpiDetailController@destroy');        

/*****************************************************************************/
 });
