<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="mainLoading" ng-if="isloading">
	<p>Loading...</p>
</div>
<div class="process_bar" ng-init="loadStatus()">
	<div class="container">
		<div class="row">
			<div>
				<ul class="process_bar_status">
					<li ng-repeat="first_stepA in first_step" class="{{($index == i) ? 'current' : ''}} {{first_step.status}}"> 
						<a href="{{first_stepA.url}}">
							<div class="icon" style="background-color: {{first_stepA.color}}">
								<img src="{{first_stepA.icon}}" title="{{first_stepA.title}}">
								<span class="line"></span>
							</div>
						</a>
						<p>{{first_stepA.title}}</p>
						<ul>
							<li ng-repeat="first_stepAinner in first_stepA.inner" class="{{($index == j) ? 'current' : ''}} {{first_stepAinner.status}}" style="background-color:{{first_stepA.color}}; 
								margin-left:{{(360- (first_stepA.inner.length)*36)/(first_stepA.inner.length+1)+3}}px; 
								margin-right:{{ $last ? (360 - (first_stepA.inner.length)*36)/(first_stepA.inner.length+1)+5 : '0';}}px ;
								">
								<span 
									ng-if="$index == j" 
									class="line" 
									style="	background-size: {{percent_t}}% 100%; 
											background-image: -moz-linear-gradient(0deg, {{first_stepA.color}} 0%, {{first_stepA.color}} 10%);
											background-image: -webkit-gradient(linear, left top, right top, color-stop(0%, #0fb8de), color-stop(100%, #0fb8de));
											background-image: -webkit-linear-gradient(0deg, {{first_stepA.color}} 0%, {{first_stepA.color}} 100%);
											background-image: -o-linear-gradient(0deg, {{first_stepA.color}} 0%, {{first_stepA.color}} 100%);
											background-image: -ms-linear-gradient(0deg, {{first_stepA.color}} 0%, {{first_stepA.color}} 100%);
											background-image: linear-gradient(90deg, {{first_stepA.color}} 0%, {{first_stepA.color}} 10%);
											filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='{{first_stepA.color}}', endColorstr='{{first_stepA.color}}',GradientType=1 );
											width: {{(360- (first_stepA.inner.length)*36)/(first_stepA.inner.length+1)+6}}px;
											left: -{{(360- (first_stepA.inner.length)*36)/(first_stepA.inner.length+1)+7}}px;"
								></span>
								<span ng-if="$index != j" class="line"
										style="	
											background-image: -moz-linear-gradient(0deg, {{first_stepA.color}} 0%, {{first_stepA.color}} 10%);
											background-image: -webkit-gradient(linear, left top, right top, color-stop(0%, #0fb8de), color-stop(100%, #0fb8de));
											background-image: -webkit-linear-gradient(0deg, {{first_stepA.color}} 0%, {{first_stepA.color}} 100%);
											background-image: -o-linear-gradient(0deg, {{first_stepA.color}} 0%, {{first_stepA.color}} 100%);
											background-image: -ms-linear-gradient(0deg, {{first_stepA.color}} 0%, {{first_stepA.color}} 100%);
											background-image: linear-gradient(90deg, {{first_stepA.color}} 0%, {{first_stepA.color}} 10%);
											filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='{{first_stepA.color}}', endColorstr='{{first_stepA.color}}',GradientType=1 );
											width: {{(360- (first_stepA.inner.length)*36)/(first_stepA.inner.length+1)+6}}px;
											left: -{{(360- (first_stepA.inner.length)*36)/(first_stepA.inner.length+1)+7}}px;""
								></span>
								<span ng-if="$last" class="line" style="width: {{(360- (first_stepA.inner.length)*36)/(first_stepA.inner.length+1)+14}}px;" 

									></span>
								<p>{{first_stepAinner.title}}</p>
								<i class="fa fa-check" aria-hidden="true"></i>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>	
</div>
<div class="form_data_sec">
	<div class="container">
		<div>
			<form name="myForm">
				<ng-include src="currentStep" ng-init="loadDeal()">
		    		    
		    	</ng-include>	
			</form>
		</div>	
	</div>
</div>
<script type="text/ng-template" id="Deal">
	<div class="dealSec">
		<div class="row">
			<div class="col-lg-6">
				<div class="dealSecIn">
					<div class="dealSecInHead">
						<div class="dealIconSec">
							<div class="dealIconSecIn blue">
								<img src="static/img/icons/deal/basic.png" width="39" height="39" at="Icon">
							</div>
							<div class="dealIconSecText">
								<p>Basic Info</p>
							</div>
						</div>
						<div class="dealEditBtn">
							<a href="#!/form/basic">Edit Your Responses</a>
						</div>
					</div>
					<div class="dealIconSecBody">
						<ul>
							<li ng-repeat="(key, value) in dealData[0]">
								<div>{{key == 'csz' ? 'City, State, Zip' : key}}</div>
								<div>{{value}}</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="dealSecIn">
					<div class="dealSecInHead">
						<div class="dealIconSec">
							<div class="dealIconSecIn red">
								<img src="static/img/icons/deal/kids.png" width="39" height="39" at="Icon">
							</div>
							<div class="dealIconSecText">
								<p>Kids</p>
							</div>
						</div>
						<div class="dealEditBtn">
							<a href="#!/form/kids">Edit Your Responses</a>
						</div>
					</div>
					<div class="dealIconSecBody">
						<ul>
							<li>
								<div>&nbsp;</div>
								<div></div>
							</li>
							<li>
								<style type="text/css">
									.progressBgMe div{
										background-color: #1063c6 !important;
										height: 43px !important;
										padding: 0 !important;
										line-height: 43px !important;
										border: {{(noofdayeswithme == 0 && noofdayeswithspouse == 0) ? '0' : ((noofdayeswithme/noofdayeswithspouse == 0) ? '0' : '1')}}px solid #1063c6 !important;
										width: {{(noofdayeswithme == 0 && noofdayeswithspouse == 0) ? '0' : (noofdayeswithme < noofdayeswithspouse ? (noofdayeswithme/noofdayeswithspouse)*100 : 100);}}% !important;
									}
								</style>
								<div class="title">Days with you</div>
								<div>
									<span class="progressBgMe"><div></div></span>
									<span>{{noofdayeswithme}}</span>
								</div>
							</li>
							<li>
								<style type="text/css">
									.progressBgSpouse div{
										background-color: #e06666 !important;
										height: 43px !important;
										padding: 0 !important;
										line-height: 43px !important;
										border: {{(noofdayeswithme == 0 && noofdayeswithspouse == 0) ? '0' : ((noofdayeswithspouse/noofdayeswithme == 0) ? '0' : '1')}}pxpx solid #e06666 !important;
										width: {{(noofdayeswithme == 0 && noofdayeswithspouse == 0) ? '0' : (noofdayeswithspouse < noofdayeswithme ? (noofdayeswithspouse/noofdayeswithme)*100 : 100);}}% !important;
									}
								</style>
								<div class="title">Days with your spouse</div>

								<div>
									<span class="progressBgSpouse"><div></div></span>
									<span>{{noofdayeswithspouse}}</span>
								</div>
							</li>
							<li>
								<style type="text/css">
									.progressBgHme div{
										background-color: rgba(16, 99, 198, 0.22) !important;
										height: 43px !important;
										padding: 0 !important;
										line-height: 43px !important;
										border: {{(noofholidayswithme == 0 && noofholidayswithspouse == 0) ? '0' : ((noofholidayswithme/noofholidayswithspouse == 0) ? '0' : '1')}}px solid #1063c6 !important;
										width: {{(noofholidayswithme == 0 && noofholidayswithspouse == 0) ? '0' : (noofholidayswithme < noofholidayswithspouse ? (noofholidayswithme/noofholidayswithspouse)*100 : 100);}}% !important;
										
									}
								</style>
								<div class="title">Holidays with you</div>
								<div>
									<span class="progressBgHme"><div></div></span>
									<span>{{noofholidayswithme}}</span>
								</div>
							</li>
							<li>
								<style type="text/css">
									.progressBgHspouse div{
										background-color: rgba(224, 102, 102, 0.39) !important;
										height: 43px !important;
										padding: 0 !important;
										line-height: 43px !important;
										border: {{(noofholidayswithme == 0 && noofholidayswithspouse == 0) ? '0' : ((noofholidayswithspouse/noofholidayswithme == 0) ? '0' : '1')}}px solid #e06666 !important;
										width: {{(noofholidayswithme == 0 && noofholidayswithspouse == 0) ? '0' : (noofholidayswithspouse < noofholidayswithme ? (noofholidayswithspouse/noofholidayswithme)*100 : 100);}}% !important;
									}
								</style>
								<div class="title">Holidays with your spouse</div>
								<div>
									<span class="progressBgHspouse"><div></div></span>
									<span>{{noofholidayswithspouse}}</span>
								</div>
							</li>
							<li>
								<div>&nbsp;</div>
								<div></div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="dealSecIn">
					<div class="dealSecInHead">
						<div class="dealIconSec">
							<div class="dealIconSecIn yellow">
								<img src="static/img/icons/deal/haveOwe.png" width="39" height="39" at="Icon">
							</div>
							<div class="dealIconSecText">
								<p>Have / Owe</p>
							</div>
						</div>
						<div class="dealEditBtn">
							<a href="#!/HaveOwe">Edit Your Responses</a>
						</div>
					</div>
					<div class="dealIconSecBody">
						<ul>
							<li>
								<style type="text/css">
									.progressBgassetsTotalMe div{
										background-color: #1063c6 !important;
										height: 43px !important;
										padding: 0 !important;
										line-height: 43px !important;
										border: {{(assetsTotal.me == 0) ? '0' : '1'}}px solid #1063c6 !important;
										width: {{assetsTotal.me < assetsTotal.spouse ? (assetsTotal.me/assetsTotal.spouse)*100 : 100;}}% !important;
									}
								</style>
								<div class="title">Your assets</div>
								<div>
									<span ng-if="assetsTotal.me != 0" class="progressBgassetsTotalMe"><div></div></span>
									<span title="{{assetsTotal.me | currency:'$':0}}">{{assetsTotal.me | currency:"$":0}}</span>
								</div>
							</li>
							<li>
								<style type="text/css">
									.progressBgassetsTotalSpouse div{
										background-color: #e06666 !important;
										height: 43px !important;
										padding: 0 !important;
										line-height: 43px !important;
										border: {{(assetsTotal.spouse == 0) ? '0' : '1'}}px solid #e06666 !important;
										width: {{assetsTotal.spouse < assetsTotal.me ? (assetsTotal.spouse/assetsTotal.me)*100 : 100;}}% !important;
									}
								</style>
								<div class="title">Your spouse’s assets</div>
								<div>
									<span ng-if="assetsTotal.spouse != 0" class="progressBgassetsTotalSpouse"><div></div></span>
									<span title="{{assetsTotal.spouse | currency:'$':0}}">{{assetsTotal.spouse | currency:"$":0}}</span>
								</div>
							</li>
							<li>
								<style type="text/css">
									.progressBgdebtTotalMe div{
										background-color: rgba(16, 99, 198, 0.22) !important;
										height: 43px !important;
										padding: 0 !important;
										line-height: 43px !important;
										border: {{(debtTotal.me == 0) ? '0' : '1'}}px solid #1063c6 !important;
										width: {{debtTotal.me < debtTotal.spouse ? (debtTotal.me/debtTotal.spouse)*100 : 100;}}% !important;
									}
								</style>
								<div class="title">Your debts</div>
								<div>
									<span ng-if="debtTotal.me != 0" class="progressBgdebtTotalMe"><div></div></span>
									<span title="{{debtTotal.me | currency:'$':0}}">{{debtTotal.me | currency:"$":0}}</span>
								</div>
							</li>
							<li>
								<style type="text/css">
									.progressBgdebtTotalSpouse div{
										background-color: rgba(224, 102, 102, 0.39) !important;
										height: 43px !important;
										padding: 0 !important;
										line-height: 43px !important;
										border: {{(debtTotal.spouse == 0) ? '0' : '1'}}px solid #e06666 !important;
										width: {{debtTotal.spouse < debtTotal.me ? (debtTotal.spouse/debtTotal.me)*100 : 100;}}% !important;
									}
								</style>
								<div class="title">Your spouse’s debts</div>
								<div>
									<span ng-if="debtTotal.spouse != 0" class="progressBgdebtTotalSpouse"><div></div></span>
									<span title="{{debtTotal.spouse | currency:'$':0}}">{{debtTotal.spouse | currency:"$":0}}</span>
								</div>
							</li>
							<li>
								<style type="text/css">
									.progressBgassetsTotalShared div{
										background-color: #38ad12 !important;
										height: 43px !important;
										padding: 0 !important;
										line-height: 43px !important;
										border: {{(assetsTotal.shared == 0) ? '0' : '1'}}px solid #38ad12 !important;
										width: {{(assetsTotal.shared < (debtTotal.shared.me + debtTotal.shared.spouse)) ? (assetsTotal.shared/(debtTotal.shared.me + debtTotal.shared.spouse))*100 : 100;}}% !important;
									}
								</style>
								<div class="title">Shared assets</div>
								<div>
									<span ng-if="assetsTotal.shared != 0" class="progressBgassetsTotalShared"><div></div></span>
									<span title="{{assetsTotal.shared | currency:'$':0}}">{{assetsTotal.shared | currency:"$":0}}</span>
								</div>
							</li>
							<li>
								<style type="text/css">
									.progressBgdebtTotalShared div{
										background-color: rgba(56, 173, 18, 0.38) !important;
										height: 43px !important;
										padding: 0 !important;
										line-height: 43px !important;
										border: {{((debtTotal.shared.me + debtTotal.shared.spouse) == 0) ? '0' : '1'}}px solid #38ad12 !important;
										width: {{((debtTotal.shared.me + debtTotal.shared.spouse)) < assetsTotal.shared ? ((debtTotal.shared.me + debtTotal.shared.spouse)/assetsTotal.shared)*100 : 100;}}% !important;
									}
								</style>
								<div class="title">Shared debts</div>
								<div>
									<span ng-if="(debtTotal.shared.me + debtTotal.shared.spouse) != 0" class="progressBgdebtTotalShared">
										<div></div>
									</span>
									<span title="{{debtTotal.shared.me + debtTotal.shared.spouse | currency:'$':0}}">{{debtTotal.shared.me + debtTotal.shared.spouse | currency:"$":0}}</span>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="dealSecIn">
					<div class="dealSecInHead">
						<div class="dealIconSec">
							<div class="dealIconSecIn green">
								<img src="static/img/icons/deal/makeSpend.png" width="39" height="39" at="Icon">
							</div>
							<div class="dealIconSecText">
								<p>Make / Spend</p>
							</div>
						</div>
						<div class="dealEditBtn">
							<a href="#!/MakeSpend">Edit Your Responses</a>
						</div>
					</div>
					<div class="dealIconSecBody">
						<ul>
							<li>
								<style type="text/css">
									.progressBgincomeTotalMe div{
										background-color: #1063c6 !important;
										height: 43px !important;
										padding: 0 !important;
										line-height: 43px !important;
										border: {{(incomeTotal.me == 0) ? '0' : '1'}}px solid #1063c6 !important;
										width: {{incomeTotal.me < incomeTotal.spouse ? (incomeTotal.me/incomeTotal.spouse)*100 : 100;}}% !important;
									}
								</style>
								<div class="title">Your total income</div>
								<div>
									<span ng-if="incomeTotal.me != 0" class="progressBgincomeTotalMe"><div></div></span>
									<span title="{{incomeTotal.me | currency:'$':0}}">{{incomeTotal.me | currency:"$":0}}</span>
								</div>
							</li>
							<li>
								<style type="text/css">
									.progressBgincomeTotalSpouse div{
										background-color: #e06666 !important;
										height: 43px !important;
										padding: 0 !important;
										line-height: 43px !important;
										border: {{(incomeTotal.spouse == 0) ? '0' : '1'}}px solid #e06666 !important;
										width: {{incomeTotal.spouse < incomeTotal.me ? (incomeTotal.spouse/incomeTotal.me)*100 : 100;}}% !important;
									}
								</style>
								<div class="title">Your spouse’s total income</div>
								<div>
									<span ng-if="incomeTotal.spouse != 0" class="progressBgincomeTotalSpouse"><div></div></span>
									<span title="{{incomeTotal.spouse | currency:'$':0}}">{{incomeTotal.spouse | currency:"$":0}}</span>
								</div>
							</li>
							<li>
								<style type="text/css">
									.progressBgexpenseTotalMe div{
										background-color: rgba(16, 99, 198, 0.22) !important;
										height: 43px !important;
										padding: 0 !important;
										line-height: 43px !important;
										border: {{(expenseTotal.me == 0) ? '0' : '1'}}px solid #1063c6 !important;
										width: {{expenseTotal.me < expenseTotal.spouse ? (expenseTotal.me/expenseTotal.spouse)*100 : 100;}}% !important;
									}
								</style>
								<div class="title">Your total expenses</div>
								<div>
									<span ng-if="expenseTotal.me != 0" class="progressBgexpenseTotalMe"><div></div></span>
									<span title="{{expenseTotal.me | currency:'$':0}}">{{expenseTotal.me | currency:"$":0}}</span>
								</div>
							</li>
							<li>
								<style type="text/css">
									.progressBgexpenseTotalSpouse div{
										background-color: rgba(224, 102, 102, 0.39) !important;
										height: 43px !important;
										padding: 0 !important;
										line-height: 43px !important;
										border: {{(expenseTotal.spouse == 0) ? '0' : '1'}}px solid #e06666 !important;
										width: {{expenseTotal.spouse < expenseTotal.me ? (expenseTotal.spouse/expenseTotal.me)*100 : 100;}}% !important;
									}
								</style>
								<div class="title">Your  spouse’s total expenses</div>
								<div>
									<span ng-if="expenseTotal.spouse != 0" class="progressBgexpenseTotalSpouse"><div></div></span>
									<span title="{{expenseTotal.spouse | currency:'$':0}}">{{expenseTotal.spouse | currency:"$":0}}</span>
								</div>
							</li>
							<li>
								<div>Employer name</div>
								<div>{{empName}}</div>
							</li>
							<li>
								<div>Tax status</div>
								<div>{{taxStatus}}</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="dealFinal">
					<a href="#">Have a question before completing your forms?</a>
					<br>
					<br>
					<button class="finalSubmit" ng-click="generateFormsDeal()">GENERATE FORMS</button>					
				</div>
			</div>
		</div>
	</div>
</script>