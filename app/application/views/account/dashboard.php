<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="overlayEnableDashboard" ng-if="overlayEnable">
	<p>
		<img src="static/img/icons/overlay/dashboard/1.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/dashboard/2.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/dashboard/3.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/dashboard/4.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/dashboard/5.png">
	</p>
	<div class="closeA" ng-click="closeOverlay()">
		<img src="static/img/icons/overlay/close.png">
	</div>
</div>
<div class="email_area">
				<div class="email_btn1"><button type="button">Email</button></div>
				<!--<div class="info_btn1">
					<a href="" ng-click="overlayShow()">
						<img src="static/img/nl/info.png" alt="info" width="35" height="35">
					</a>
				</div>-->
			</div>

			<div class="tell_us">				
				<div class="container dashboard_head_top">
					<h1>Your Dashboard<br></h1><br>
					<a href="" ng-click="overlayShow()">
						<img src="static/img/nl/dashboard_top.png" alt="dashboard Icon">
					</a>
				</div>
			</div>

			<!--ACCORDIN SECTION STARTS -->
			<div class="container">
			    <v-accordion id="accordionA" class="vAccordion--default" control="accordionA" ng-init="initProcess()">
		           <v-pane id="{{ ::pane.id }}" ng-repeat="pane in panesA" expanded="pane.isExpanded" ng-disabled="$last">
		              <v-pane-header id="{{ ::pane.id }}-header" aria-controls="{{ ::pane.id }}-content">
		              	<style type="text/css">
		              		.dashboardProgress{{$index}}{
		              			background-size: {{ pane.status }}% 100%; 
		              		}
		              	</style>

		                <h4 id="acc_title" class="dashboardProgress{{$index}}" data-width="{{ ::pane.status }}" style="">
		                	<span class="per_are">{{ pane.status | number:0}}%</span>
							<div class="content">{{ pane.header }}</div>
							<div ng-if="!$last">
								<a class="{{ pane.status == 100 ? 'view' : pane.status == 0 ? 'start' : 'resume' }}" ng-click="viewForm(pane.url)">
									{{ pane.status == 100 ? 'View' : pane.status == 0 ? 'Start' : 'Resume' }}
								</a>	
							</div>
							<div ng-if="$last">
								<a ng-if="isDealCompleted" class="{{ pane.status == 100 ? 'view' : pane.status == 0 ? 'start' : 'resume' }}" ng-click="viewForm(pane.url)">
									Review
								</a>
								<a ng-if="!isDealCompleted" class="inprogress">
									In progress
								</a>	
							</div>
							
		                </h4>
		              </v-pane-header>
		              <v-pane-content id="{{ ::pane.id }}-content" aria-labelledby="{{ ::pane.id }}-header">
		                	<div class="panel-body">
		                		<div class="row">
	                				<ul class="process_status">
	                					<li ng-repeat="contentsec in pane.content">
	                						<div class="steps-{{ contentsec.id}}">
	                							<style type="text/css">
	                								.process_status li .icon.iconbg{{$index}}{{$parent.$index}}{
                										background: {{ contentsec.color}};
	                								}
	                							</style>
	                							<div class="icon iconbg{{$index}}{{$parent.$index}} {{ contentsec.status}}" style="">
	                								<img src="{{ contentsec.icon}}" title="{{ contentsec.title}}"/>
	                								<span class="line"></span>
	                							</div>
	                							<p>{{ ::contentsec.title}}</p>
	                						</div>
	                					</li>
	                				</ul>
		                		</div>
	                        </div>
		              </v-pane-content>
		            </v-pane> 
	          </v-accordion>
			</div>
			<!--ACCORDIN SECTION ENDS -->
<div class="container">
				<div class="legalForms">
					<table>
						<tbody>
							<tr>
								<td>
									<img src="static/img/icons/pdff.png" title="icon" />
									<p>FL 100 – Petition Marriage/Domestic Partnership</p>
								</td>
								<td><a href="" ng-click="downloadForm('fl100')">Re-download</a></td>
								<td>
									<a href="" ng-click="generateForms()">
										Regenerate <br> <span>(you can do this once)</span> 
									</a>
								</td>
							</tr>
							<tr>
								<td>
									<img src="static/img/icons/pdff.png" title="icon" />
									<p>
										FL 105 – Declaration Under Uniform Child Custody 
										<span>Jurisdiction and Enforcement Act (UCCJEA)</span>
									</p>
								</td>
								<td>
									<a href="" ng-click="downloadForm('fl105')">Re-download</a>
								</td>
								<td>
									<a href="" ng-click="generateForms()">
										Regenerate <br> <span>(you can do this once)</span> 
									</a>
								</td>
							</tr>
							<tr>
								<td>
									<img src="static/img/icons/pdff.png" title="icon" />
									<p>FL 110 – Family Law Summons</p>
								</td>
								<td><a href="" ng-click="downloadForm('fl110')">Re-download</a></td>
								<td>
									<a href="" ng-click="generateForms()">
										Regenerate <br> <span>(you can do this once)</span> 
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- <div class="chat-sec"><a href="#"><img src="static/img/nl/callout.png"></a></div> -->


         
