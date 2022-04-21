<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
?> 
  <header class="page-header">
            
          </header>
          <section class="dashboard-header pb-0">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="bg-white p-4">
                    <form class="form-inline mb-0">
                      <div class="form-group mr-3">
                        <input type="text" placeholder="DD/MM/YYYY" class="form-control">
                      </div>
                      <div class="form-group mr-3">
                        <input type="text" placeholder="DD/MM/YYYY" class="form-control">
                      </div>
                      <div class="form-group mr-3">
                        <button class="btn btn-add">Submit</button>
                      </div>
                      <div class="form-group">
                        <button class="btn btn-add">Download</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
              <div class="row bg-white has-shadow">
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-violet"><i class="fa fa-list-alt"></i></div>
                    <div class="title"><span>Total Orders</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 25%; height: 4px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-violet"></div>
                      </div>
                    </div>
                    <div class="number"><strong>25</strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-green"><i class="fa fa-check"></i></div>
                    <div class="title"><span>Success Orders</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 70%; height: 4px;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-green"></div>
                      </div>
                    </div>
                    <div class="number"><strong>70</strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-red"><i class="fa fa-times"></i></div>
                    <div class="title"><span>Cancelled Orders</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 40%; height: 4px;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-red"></div>
                      </div>
                    </div>
                    <div class="number"><strong>40</strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-orange"><i class="fa fa-spinner"></i></div>
                    <div class="title"><span>Pending Orders</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 40%; height: 4px;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-orange"></div>
                      </div>
                    </div>
                    <div class="number"><strong>40</strong></div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section class="dashboard-header">
            <div class="container-fluid">
              <div class="row">
                <!-- Statistics -->
                <div class="statistics col-lg-3 col-12">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-red"><i class="fa fa-money"></i></div>
                    <div class="text"><strong>234</strong><br><small>Paid By Cash</small></div>
                  </div>
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-green"><i class="fa fa-globe"></i></div>
                    <div class="text"><strong>152</strong><br><small>Paid By Paytm</small></div>
                  </div>
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-orange"><i class="fa fa-globe"></i></div>
                    <div class="text"><strong>147</strong><br><small>Paid By Gpay</small></div>
                  </div>
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-violet"><i class="fa fa-globe"></i></div>
                    <div class="text"><strong>147</strong><br><small>Paid By Phonepay</small></div>
                  </div>
                </div>
                <!-- Line Chart            -->
                <div class="chart col-lg-5 col-12">
                  <div id="chart-container"></div>
                </div>
                <div class="statistics col-lg-4 col-12">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-red"><i class="fa fa-user-secret"></i></div>
                    <div class="text"><strong>234</strong><br><small>Total Pilots</small></div>
                  </div>
                  <div class="card">
                    <div class="card-header d-flex align-items-center pt-0 pb-0">
                      <h3 class="h4 col-md-6 pl-0 tab-title">Food Sale Report</h3>
                    <div class="col-md-6 text-right pr-0">
                      <select class="form-control">
                        <option>Today</option>
                        <option>Week</option>
                        <option>Month</option>
                      </select>
                    </div>
                    </div>
                    <div class="card-body">
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section> 
          