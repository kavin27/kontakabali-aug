<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="mainLoading" ng-if="isloading">
	<p>Loading...</p>
</div>
<div class="overlayA" ng-if="overlayEnable && !isloading">
	<p>
		<img src="static/img/icons/overlay/o1.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/o2.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/o3.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/o4.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/o5.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/o6.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/o7.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/o8.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/o9.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/o10.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/o11.png">
	</p>
	<div class="closeA" ng-click="closeOverlay()">
		<img src="static/img/icons/overlay/close.png">
	</div>
</div>
<div ng-if="!formHide" class="process_bar" ng-init="loadCurrentJob()">
	<div class="container">
		<div class="row">
			<div>
				<ul class="process_bar_status">
					<li ng-repeat="first_stepA in first_step" class="{{($index == i) ? 'current' : ''}} {{first_stepA.status}}"> 
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
<div ng-if="!formHide" class="makeSpendFormSec">
	<div class="container">
		<div ng-if="skipNav" class="row">
			<div class="col-lg-12">
				<div class="formNav">
					<a ng-if="myForm.$valid" href="" ng-click="saveCurrentJob(makeSpendCurrentJob)" class="next">
						<svg x="0px" y="0px" width="112.964px" height="52.316px" viewBox="0 0 112.964 52.316" enable-background="new 0 0 112.964 52.316" xml:space="preserve">
							<g>
								<path fill="#188E45" d="M107.81,23.712C101.301,16.702,90.809,5.59,89.7,5.59H2.933C1.313,5.59,0,6.903,0,8.523v40.861
						c0,1.62,1.313,2.933,2.933,2.933h87.465c1.62,0,22.566-23.014,22.566-23.014v-5.59H107.81z"/>
								<path fill="#27B34B" d="M89.7,47.424H2.933C1.313,47.424,0,46.111,0,44.492V2.933C0,1.313,1.313,0,2.933,0H89.7
						c1.62,0,23.264,23.712,23.264,23.712S91.319,47.424,89.7,47.424z"/>
								<g id="Button__x28_find_out_if_I_qualify_x29__1_">
									<text transform="matrix(1 0 0 1 30.1124 32.6964)" fill="#FFFFFF" font-family="'Lato', sans-serif" font-size="19">NEXT</text>
								</g>
							</g>
						</svg>
					</a>
					<a ng-if="myForm.$invalid" href="" ng-click="invalid()" class="next">
						<svg x="0px" y="0px" width="112.964px" height="52.316px" viewBox="0 0 112.964 52.316" enable-background="new 0 0 112.964 52.316" xml:space="preserve">
							<g>
								<path fill="#188E45" d="M107.81,23.712C101.301,16.702,90.809,5.59,89.7,5.59H2.933C1.313,5.59,0,6.903,0,8.523v40.861
						c0,1.62,1.313,2.933,2.933,2.933h87.465c1.62,0,22.566-23.014,22.566-23.014v-5.59H107.81z"/>
								<path fill="#27B34B" d="M89.7,47.424H2.933C1.313,47.424,0,46.111,0,44.492V2.933C0,1.313,1.313,0,2.933,0H89.7
						c1.62,0,23.264,23.712,23.264,23.712S91.319,47.424,89.7,47.424z"/>
								<g id="Button__x28_find_out_if_I_qualify_x29__1_">
									<text transform="matrix(1 0 0 1 30.1124 32.6964)" fill="#FFFFFF" font-family="'Lato', sans-serif" font-size="19">NEXT</text>
								</g>
							</g>
						</svg>
					</a>
				</div>	
			</div>
		</div>
		<div>
			<form name="myForm">
				<div class="makeSpendFromIn">
					<div class="row">
						<p>Tell us about your current job, if you’re unemployed, your most recent job:</p>
					</div>
					<div class="row">
						<div class="makeSpendFromInIn">
							<div class="row">
								<div class="col-lg-5">
									<input 
										type="text" 
										name="name" 
										class="{{(myForm.name.$invalid && saveCurrentJoberror) ? 'error' : ''}}" 
										placeholder="Employer name" 
										ng-model="makeSpendCurrentJob.name"
										maxlength="50" 
										alphapet
										required>
								</div>
								<div class="col-lg-7">
									<md-radio-group 
										ng-model="makeSpendCurrentJob.type"	
										name="why" 
										class="{{(myForm.why.$invalid && saveCurrentJoberror) ? 'error' : ''}}"
										required>
			    						<md-radio-button value="Self-Employed Owner/Sole-proprietor" class="md-primary">Self-Employed Owner /Sole-proprietor</md-radio-button>
			    						<md-radio-button value="Self-Employed Business Partner" class="md-primary">Self-Employed<br /> Business Partner</md-radio-button>
			    					</md-radio-group>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<input 
										type="text" 
										name="address1" 
										class="{{(myForm.address1.$invalid && saveCurrentJoberror) ? 'error' : ''}}" 
										ng-model="makeSpendCurrentJob.address1" 
										placeholder="Street address"
										maxlength="150" 
										required>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<input 
										type="text" 
										name="address2" 
										class="{{(myForm.address2.$invalid && saveCurrentJoberror) ? 'error' : ''}}" 
										ng-model="makeSpendCurrentJob.address2" 
										placeholder="Address"
										maxlength="150" 
										>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-7">
									<input 
										type="text" 
										name="city" 
										class="{{(myForm.city.$invalid && saveCurrentJoberror) ? 'error' : ''}}" 
										ng-model="makeSpendCurrentJob.city" 
										maxlength="50" 
										placeholder="City"
										alphapet
										required>
								</div>
								<div class="col-lg-5">
									<div class="row">
										<div class="col-md-6">
											<input 
												type="text" 
												name="state"
												class="{{(myForm.state.$invalid && saveCurrentJoberror) ? 'error' : ''}}" 
												ng-model="makeSpendCurrentJob.state" 
												placeholder="State"
												maxlength="50" 
												alphapet
												required>
										</div>
										<div class="col-md-6">
											<input 
												type="text" 
												name="zip" 
												class="{{(myForm.zip.$invalid && saveCurrentJoberror) ? 'error' : ''}}" 
												ng-model="makeSpendCurrentJob.zip" 
												placeholder="Zip Code"
												maxlength="5" 
												numbers
												required>		
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-5">
									<div 
                    					datepicker 
										date-format="MM/dd/yyyy"
										date-typer="true">
										<input 
											type="text" 
											name="startDate" 
											class="{{(myForm.startDate.$invalid && saveCurrentJoberror) ? 'error' : ''}}" 
											ng-model="makeSpendCurrentJob.startDate" 
											placeholder="Date started (mm/dd/yyyy)"
											required>
								    </div>	
									<!--<input type="text" name="" placeholder="Date started (mm/dd/yyyy)">-->
								</div>
								<div class="col-lg-7">
									<div 
                    					datepicker 
										date-format="MM/dd/yyyy"
										date-typer="true">
										<input 
											type="text" 
											name="endDate" 
											class="{{(myForm.endDate.$invalid && saveCurrentJoberror) ? 'error' : ''}}" 
											ng-model="makeSpendCurrentJob.endDate" 
											placeholder="If unemployed, date ended (mm/dd/yyyy)"
											>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<p>
										What is your tax status?
										<md-radio-group 
											ng-model="makeSpendCurrentJob.taxStatus" 
											name="taxStatus" 
											class="{{(myForm.taxStatus.$invalid && saveCurrentJoberror) ? 'error' : ''}}"
											required>
				    						<md-radio-button value="Single" class="md-primary">
				    							Single
				    						</md-radio-button>
				    						<md-radio-button value="Married, filing single" class="md-primary">
				    							Married, filing single
				    						</md-radio-button>
				    						<md-radio-button value="Married, filing jointly" class="md-primary">
				    							Married, filing jointly
				    						</md-radio-button>
				    					</md-radio-group>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- <ng-include src="MakeSpendStep">

				</ng-include> -->
			</form>
		</div>	
	</div>
</div>
<div ng-if="formHide">
	<header ng-if="!ShowReview" class="haveOweHead">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-4 offset-0">
					<nav>
						<ul class="nav navbar-nav">
							<li class="dropdown">
								<a class="btn btn-default dropdown-toggle addNew" style="display: none;" ng-click="addNewToggle('income')">+ Add New Income</a>
								<div ng-if="incomenewshow" class="addNewAssetsForm addNewIncomeFormSec">
									<div ng-include src="'addNewIncomeForm'"></div>
								</div>
								<div ng-if="incomenewshow" class="overlayaddnew" ng-click="addNewClose('income')">
								
								</div>
							</li>
							<li class="dropdown">
								<a class="btn btn-default dropdown-toggle addNew" style="display: none;" ng-click="addNewToggle('expense')">+ Add New Expense</a>
								<div ng-if="expensenewshow" class="addNewAssetsForm addNewExpenseFormSec">
									<div ng-include src="'addNewExpenseForm'"></div>
								</div>
								<div ng-if="expensenewshow" class="overlayaddnew overlayexpense" ng-click="addNewClose('expense')">
								
								</div>
							</li>
						</ul>
					</nav>
				</div>		
				<div class="col-lg-4 text-center offset-0">
					<div>
						<a href="" ng-click="openOverlay()">
							<img src="static/img/nl/dashboard_top.png">
						</a>
					</div>
				</div>
				<div class="col-lg-4 text-right offset-0">
					<nav>
						<ul class="nav navbar-nav rightNav">
							<li class="dropdown">
								<a class="btn btn-default dropdown-toggle addNew" data-toggle="dropdown">History</a>
								<div class="dropdown-menu HistoryDropDown">
									<div ng-include src="'History'"></div>
								</div>
							</li>
							<li>
								<!--<a class="btn btn-default addNew" href="http://localhost/IOE/api/auth/csv">Export </a>-->
								<a class="btn btn-default addNew" data-toggle="dropdown">Export </a>
								<ul class="dropdown-menu">
									<li>
										<a href="api/auth/csvMakeSpend">CSV</a>
									</li>
									<li>
										<a href="api/auth/pdfMakeSpend">PDF</a>
									</li>
								</ul>
							</li>
							<li>
								<a class="btn btn-default dropdown-toggle addNew saveBtn" ng-click="complete()" data-toggle="dropdown">Complete</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>		
		</div>
	</header>

	<section ng-if="!ShowReview" ng-init="loadData()">
		<div class="incomeHead">
			<div ng-repeat="(key, value) in total.incomeTotal" class="col-md-6">
				<span class="totlaAmount left">{{value | currency:"$":0}}</span>
				<div class="right">

					<button ng-if="$first" ng-click="addNewToggle('income', 'Me')">+ Add My Income</button>
					<button ng-if="$last" ng-click="addNewToggle('income', 'Spouse')">+ Add Spouse Income</button>
				</div>
			</div>
		</div>
		<div class="incomeBody">
			<div ng-repeat="(listName, list) in models.listsIncome" class="col-md-6">
				<p ng-if="$first" class="typeHead">Income</p>
				<h1>{{listName == 'Spouse' ? 'My Spouse' : listName}}</h1>
			    <ul class="incomeList">
			        <li ng-repeat="item in list" 
			        	>
		            	<div class="hoverOption">
			            	<ul>
			            		<li>
			            			<a href="" ng-click="delete('income',item.id)">Delete</a>
			            		</li>
			            		<li>
			            			<a href="" ng-click="edit(item.id, 'income')">Edit</a>
			            		</li>
			            	</ul>
			            </div>
			            <div class="incomeIcon">
		            		<img src="static/img/icons/make_spend/income/{{item.incomeType}}.png">
			            </div>
			            <div class="assetText">
			            	<span>{{item.howMuchIncome | currency:"$":0}}</span>
		            		<span>{{item.howOften}} {{incomeTypeList[item.incomeType].title}} </span>
		            		<span class="typeNameM">{{item.incomeName}}</span>
			            </div>
			        </li>
			    </ul>
			</div>
		</div>
		<div class="expenseHead">
			<div ng-repeat="(key, value) in total.expenseTotal" class="col-md-6">
				<span class="totlaAmount left red">-{{value | currency:"$":0}}</span>
				<div class="right">
					<button ng-if="$first" ng-click="addNewToggle('expense', 'Me')">+ Add My Expense</button>
					<button ng-if="$last" ng-click="addNewToggle('expense', 'Spouse')">+ Add Spouse Expense</button>
				</div>
			</div>
		</div>
		<div class="expenseBody">
			<div ng-repeat="(listName, list) in models.listExpense" class="col-md-6">
				<p ng-if="$first" class="typeHead">Expense</p>
			    <ul class="expenseList">
			        <li ng-repeat="item in list"
			        	>
		            	<div class="hoverOption">
			            	<ul>
			            		<li>
			            			<a href="" ng-click="delete('expense', item.id)">Delete</a>
			            		</li>
			            		<li>
			            			<a href="" ng-click="edit(item.id, 'expense')">Edit</a>
			            		</li>
			            	</ul>
			            </div>
			            <div class="assetIcon">
		            		<img src="static/img/icons/make_spend/expense/{{item.expenseType}}.png">
			            </div>
			            <div class="assetText">
			            	<span >{{item.expenseEstimation | currency:"$":0}}</span>
		            		<span>{{item.howOftenYouPay}} {{expenseTypeList[item.expenseType].title}}</span>
		            		<span class="typeNameM">{{item.expenseName}}</span>
			            </div>
			        </li>
			    </ul>
			</div>
		</div>
		<div class="expenseHead">
			<div ng-repeat="(key, value) in total.expenseTotal" class="col-md-6">
				<span class="totlaAmount {{$first ? 'left' : 'right'}} red">&nbsp;</span>
			</div>
		</div>
	</section>
	<div ng-if="ShowReview" class="makeSpendReview">
		<div class="container">
			<!-- <div class="row">
				<div class="col-lg-12">
					<div class="formNav">
						<a href="#/Deal" class="next">
							<svg x="0px" y="0px" width="112.964px" height="52.316px" viewBox="0 0 112.964 52.316" enable-background="new 0 0 112.964 52.316" xml:space="preserve">
								<g>
									<path fill="#188E45" d="M107.81,23.712C101.301,16.702,90.809,5.59,89.7,5.59H2.933C1.313,5.59,0,6.903,0,8.523v40.861
							c0,1.62,1.313,2.933,2.933,2.933h87.465c1.62,0,22.566-23.014,22.566-23.014v-5.59H107.81z"/>
									<path fill="#27B34B" d="M89.7,47.424H2.933C1.313,47.424,0,46.111,0,44.492V2.933C0,1.313,1.313,0,2.933,0H89.7
							c1.62,0,23.264,23.712,23.264,23.712S91.319,47.424,89.7,47.424z"/>
									<g id="Button__x28_find_out_if_I_qualify_x29__1_">
										<text transform="matrix(1 0 0 1 30.1124 32.6964)" fill="#FFFFFF" font-family="'Lato', sans-serif" font-size="19">NEXT</text>
									</g>
								</g>
							</svg>
						</a>
					</div>	
				</div>
			</div> -->
			<div class="row">
			<br>
			<br>
				<a href="" ng-click="gobackMakeSpend()" class="previous">Previous</a>
				<h1 class="reviewHead">Review</h1>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<h1 class="reviewInnerHead">Me</h1>
				</div>
				<div ng-if="models.listsIncome.Me.length" class="col-lg-12">
					<h2 class="reviewInnerTypeHead">Income</h2>
					<ul>
						<li ng-repeat="items in models.listsIncome.Me">
							<div>
								<div class="icon">
									<img src="static/img/icons/make_spend/income/{{items.incomeType}}.png" alt="icon" width="31" height="31">
								</div>
								<span>{{items.howOften}} {{incomeTypeList[items.incomeType].title}}</span>
								<span>{{items.howMuchIncome | currency:"$":0}}</span>
							</div>
							<div>
								<a ng-click="edit(items.id, 'income')">Edit</a>
							</div>
						</li>
					</ul>
				</div>
				<div class="col-lg-12" ng-if="models.listsIncome.Me.length">
					<div class="total_sec">
						<div class="backtoDash">
							<a href="" ng-click="gobackMakeSpend()">+ Add Income</a>
						</div>
						<div class="total_val">
							Total: ${{total.incomeTotal.me }}
						</div>
					</div>
				</div>
				<div ng-if="models.listExpense.Me.length" class="col-lg-12">
					<h2 class="reviewInnerTypeHead red">Expense</h2>
					<ul>
						<li ng-repeat="items in models.listExpense.Me">
							<div>
								<div class="icon">
									<img src="static/img/icons/make_spend/expense/{{items.expenseType}}.png" alt="icon" width="31" height="31">
								</div>
								<span class="red">{{items.howOftenYouPay}} {{expenseTypeList[items.expenseType].title}}</span>
								<span class="red">-{{items.expenseEstimation | currency:"$":0}}</span>
							</div>
							<div>
								<a ng-click="edit(items.id, 'expense')">Edit</a>
							</div>
						</li>
					</ul>
				</div>
				<div class="col-lg-12" ng-if="models.listExpense.Me.length">
					<div class="total_sec red">
						<div class="backtoDash">
							<a href="" ng-click="gobackMakeSpend()">+ Add Expense</a>
						</div>
						<div class="total_val">
							Total: -{{total.expenseTotal.me | currency:"$":0}}
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<h1 class="reviewInnerHead">Spouse</h1>
				</div>
				<div ng-if="models.listsIncome.Spouse.length" class="col-lg-12">
					<h2 class="reviewInnerTypeHead">Income</h2>
					<ul>
						<li ng-repeat="items in models.listsIncome.Spouse">
							<div>
								<div class="icon">
									<img src="static/img/icons/make_spend/income/{{items.incomeType}}.png" alt="icon" width="31" height="31">
								</div>
								<span>{{items.howOften}} {{incomeTypeList[items.incomeType].title}}</span>
								<span>{{items.howMuchIncome | currency:"$":0}}</span>
							</div>
							<div>
								<a ng-click="edit(items.id, 'income')">Edit</a>
							</div>
						</li>
					</ul>
				</div>
				<div ng-if="models.listsIncome.Spouse.length" class="col-lg-12">
					<div class="total_sec">
						<div class="backtoDash">
							<a href="" ng-click="gobackMakeSpend()">+ Add Income</a>
						</div>
						<div class="total_val">
							Total: {{total.incomeTotal.spouse | currency:"$":0}}
						</div>
					</div>
				</div>
				<div ng-if="models.listExpense.Spouse.length" class="col-lg-12">
					<h2 class="reviewInnerTypeHead red">Expense</h2>
					<ul>
						<li ng-repeat="items in models.listExpense.Spouse">
							<div>
								<div class="icon">
									<img src="static/img/icons/make_spend/expense/{{items.expenseType}}.png" alt="icon" width="31" height="31">
								</div>
								<span class="red">{{items.howOftenYouPay}} {{expenseTypeList[items.expenseType].title}}</span>
								<span class="red">-{{items.expenseEstimation | currency:"$":0}}</span>
							</div>
							<div>
								<a ng-click="edit(items.id, 'expense')">Edit</a>
							</div>
						</li>
					</ul>
				</div>
				<div ng-if="models.listExpense.Spouse.length" class="col-lg-12">
					<div class="total_sec red">
						<div class="backtoDash">
							<a href="" ng-click="gobackMakeSpend()">+ Add Expense</a>
						</div>
						<div class="total_val">
							Total: -{{total.expenseTotal.spouse | currency:"$":0}}
						</div>
					</div>
				</div>
				<br>
				<div class="col-lg-12 text-center">
					<a href="#!/dashboard">
						<button type="button" class="ContinueBtn">Continue</button>
					</a>	
				</div>
			</div>
		</div>
	</div>
</div>
<div ng-if="openPopUp" class="overlay">
	<div class="PopUp">
		<div ng-click="PopUpHide()" class="PopUpClose">X</div>
		<div ng-include src="PopUpTemp"></div>
	</div>
</div>
<script type="text/ng-template" id="Step1">
	<div>
		<p>Provide us with your employer's address:</p>
		<div class="empAddress">
			<label>Employer's Address(includes self-employment work address):</label>
			<input type="text" name="eAddress" placeholder="Street address" ng-model="emForm.eAddress" required>
		</div>
		<div class="empAddress2">
			<label>Suite, unit, building</label>
			<input type="text" name="eAddress2" placeholder="Suite, unit, building no." ng-model="emForm.eAddress2">
		</div>
		<div class="empCity">
			<label>City</label>
			<input type="text" name="eCity" placeholder="City" ng-model="emForm.ecity" required />
		</div>
		<div class="empState">
			<label>State</label>
			<input type="text" name="eState" placeholder="State" ng-model="eState" required />
		</div>
		<div class="empZip">
			<label>Zip Code</label>
			<input type="text" name="eZip" ng-model="emForm.eZip" placeholder="Zip Code" required />
		</div>
		<div class="empPhone">
			<label>Phone Number</label>
			<input type="text" name="ePhone" ng-model="emForm.ePhone" placeholder="(000) 000-0000" required />
		</div>
	</div>
</script>
<script type="text/ng-template" id="addNewIncomeForm">
	<form name="addIncomeForm" novalidate>
		<!-- <div class="row">
			<div class="col-lg-12">
				<p>
					Who does the income belong to?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<md-radio-group ng-model="addIncomeData.incomeBelongto" 
						name="assetBelongto" 
						class="{{(addIncomeValidate) ? (addIncomeForm.incomeBelongto.$valid ? 'valid' : 'error') : ''}}"
						required>
				    	<md-radio-button value="Me" class="md-primary">Me</md-radio-button>
				    	<md-radio-button value="Spouse" class="md-primary">Spouse</md-radio-button>
				    </md-radio-group>
				</p>				
			</div>
		</div> -->
		<div class="row">
			<div class="col-lg-7">
				<p class="aift">Add Your Income</p>
				<div class="{{(addIncomeValidate) ? (addIncomeForm.incomeType.$valid ? 'valid' : 'error') : ''}}">
					<!-- <md-select placeholder="What type of income?" ng-model="addIncomeData.incomeType" data-md-container-class="selectdemoSelectHeader" required>
			            <md-option ng-value="$index" ng-repeat="list in incomeTypeList">
			              <img height="41px" width="41px" src="static/img/icons/make_spend/income/{{$index}}.png">
			              <span>
			              	{{list.title}}<br />
			              	<span ng-if="list.subtitle!=''" class="subtitle">{{$first ? '' : list.subtitle}}</span>
			              </span>
			              
			            </md-option>
			        </md-select> -->	
			        <select custom-select="" ng-model="addIncomeData.incomeType" name="incomeType" ng-required="true" required>
			        	<option value="" src="">What type of income?</option>
			        	<option value="1" src="static/img/icons/make_spend/income/1.png">Salary or wages</option>
			        	<option value="2" src="static/img/icons/make_spend/income/2.png">Overtime</option>
			        	<option value="3" src="static/img/icons/make_spend/income/3.png">Commissions or bonus</option>
			        	<option value="4" src="static/img/icons/make_spend/income/4.png">Public assistance</option>
			        	<option value="5" src="static/img/icons/make_spend/income/5.png">Spousal support</option>
			        	<option value="6" src="static/img/icons/make_spend/income/6.png">Pension/retirement fund payments</option>
			        	<option value="7" src="static/img/icons/make_spend/income/7.png">Social security retirement</option>
			        	<option value="8" src="static/img/icons/make_spend/income/8.png">Disability</option>
			        	<option value="9" src="static/img/icons/make_spend/income/9.png">Unemployment compensation</option>
			        	<option value="10" src="static/img/icons/make_spend/income/10.png">Worker's compensation</option>
			        	<option value="11" src="static/img/icons/make_spend/income/11.png">Other</option>
			        	<option value="12" src="static/img/icons/make_spend/income/12.png">Self-employment</option>
			        </select>
				</div>
				<div>
					<input 
						type="text" 
						class="aiNa {{(addIncomeValidate) ? (addIncomeForm.incomeName.$valid ? 'valid' : 'error') : ''}}" 
						name="incomeName" 
						placeholder='Name this income, e.g. "Acme Inc. salary"'
						ng-model="addIncomeData.incomeName"
						required>
				</div>
			</div>
			<div class="col-lg-5">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="aidesc">Provide a short descritopn of the income, including any existing payment terms. <br>
					Include specifics, includeing partial account id or identification number. <br>
					For example, Apple Inc. W2 salary. <br>
					<a href="">Your documents will be incomplete without a description.</a>
				</p>
			</div>
		</div>

		<!-- <div class="row">
			<div class="col-lg-12">
				<p class="content">Give us a short description of the income. Include specifics, including employer name or <br />tax ID. For example, Apple Inc. W2 salary, or 1099 tax ID ending #1345. Your <br />documents will be considered incomplete without this information.</p>
			</div>
		</div> -->
		<div class="row">
			<div class="col-lg-12">
				<textarea ng-model="addIncomeData.description" 
					name="description" 
					class="{{(addIncomeValidate) ? (addIncomeForm.description.$valid ? 'valid' : 'error') : ''}}" 
					placeholder="Description goes here ..." 
					required
					></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<p class="discr_content">How much is this income?</p>
			</div>
			<div class="col-lg-4">
				<input type="text"
					name="howMuchIncome" 
					class="{{(addIncomeValidate) ? (addIncomeForm.howMuchIncome.$valid ? 'valid' : 'error') : ''}}" 
					ng-model="addIncomeData.howMuchIncome" 
					placeholder="$000,000,000" 
					validate="false" 
					restrict="reject"
					clean="true"
					limit="false"  
					mask="$99999999999999999"
					maxlength="20" 
					required>
				
			</div>
		</div>
		<div class="row">
			<div class="col-lg-5">
				<p>How often is this income paid?</p>
			</div>
			<div class="col-lg-7">
				<md-radio-group ng-model="addIncomeData.howOften" 
					name="howOften" 
					class="{{(addIncomeValidate) ? (addIncomeForm.howOften.$valid ? 'valid' : 'error') : ''}}"
					required>
			    	<md-radio-button value="Monthly" class="md-primary">Monthly</md-radio-button>
			    	<md-radio-button value="Bi-weekly" class="md-primary">Bi-weekly</md-radio-button>
			    	<md-radio-button value="Weekly" class="md-primary">Weekly</md-radio-button>
			    	<md-radio-button value="Hourly" class="md-primary">Hourly</md-radio-button>
			    </md-radio-group>
			</div>
		</div>
		<!-- <div class="row">
			<div class="col-lg-12">
				<p>Do you have any additional details to add about this asset? For example, plans to close <br />or transfer financial accounts, changing the title on cars, arrangements for dividing up <br />personal items like furniture.</p>
			</div>
		</div> -->
		<!-- <div class="row">
			<div class="col-lg-12">
				<textarea 
					ng-model="addIncomeData.additionalDetails" 
					name="additional" 
					placeholder="Additional details go here ...">
				</textarea>
			</div>
		</div> -->
		<div class="row">
			<div class="col-lg-7">
				<label ng-if="addIncomeValidate && addIncomeForm.$invalid" class="error">Your form is missing information. Please check your responses.</label>
			</div>
			<div class="col-lg-5">
				<p ng-if="addIncomeValidate"></p>
				<a href="" class="aiCn" ng-click="addNewClose('income')">Cancel</a>
				<button ng-if="addIncomeForm.$valid" ng-disabled="addIncomeForm.$invalid" ng-click="addIncome(addIncomeData)">Add Income</button>
				<button ng-if="addIncomeForm.$invalid" ng-click="validateAddIncome()">Add Income</button>
			</div>
		</div>
	</form>
</script>

<script type="text/ng-template" id="addNewExpenseForm">
	<form name="addExpenseForm" novalidate>
		<!-- <div class="row">
			<div class="col-lg-12">
				<p>
					Who does the expense belong to?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<md-radio-group ng-model="addExpenseData.belongTo" 
						name="belongTo"
						class="{{(addExpenseValidate) ? (addAssetsForm.belongTo.$valid ? 'valid' : 'error') : ''}}"
						required>
				    	<md-radio-button value="Me" class="md-primary">Me</md-radio-button>
				    	<md-radio-button value="Spouse" class="md-primary">Spouse</md-radio-button>
				    </md-radio-group>
				</p>				
			</div>
		</div> -->
		<div class="row">
			<div class="col-lg-7">
				<p class="aeft">Add Your expense</p>
				<div class="{{(addExpenseValidate) ? (addExpenseForm.expenseType.$valid ? 'valid' : 'error') : ''}}">
					<!-- <md-select placeholder="What type of expense?" ng-model="addExpenseData.expenseType" data-md-container-class="selectdemoSelectHeader" required>
			            <md-option ng-value="$index" ng-repeat="list in expenseTypeList">
			              <img height="41px" width="41px" src="static/img/icons/make_spend/expense/{{$index}}.png">
			              <span>{{list.title}}</span>
			            </md-option>
			        </md-select> -->	
			        <select custom-select="" ng-model="addExpenseData.expenseType" name="expenseType" ng-required="true" required>
			        	<option value="" src="">What type of expense?</option>
			        	<option value="1" src="static/img/icons/make_spend/expense/1.png">Auto</option>
			        	<option value="2" src="static/img/icons/make_spend/expense/2.png">Charitable contributions</option>
			        	<option value="3" src="static/img/icons/make_spend/expense/3.png">Child care</option>
			        	<option value="4" src="static/img/icons/make_spend/expense/4.png">Clothes</option>
			        	<option value="5" src="static/img/icons/make_spend/expense/5.png">Education</option>
			        	<option value="6" src="static/img/icons/make_spend/expense/6.png">Groceries/household</option>
			        	<option value="7" src="static/img/icons/make_spend/expense/7.png">Home</option>
			        	<option value="8" src="static/img/icons/make_spend/expense/8.png">Health-care cost not paid insurance</option>
			        	<option value="9" src="static/img/icons/make_spend/expense/9.png">Homeowner's insurance</option>
			        	<option value="10" src="static/img/icons/make_spend/expense/10.png">Installment payments</option>
			        	<option value="11" src="static/img/icons/make_spend/expense/11.png">Insurance</option>
			        	<option value="12" src="static/img/icons/make_spend/expense/12.png">Laundry/cleaning</option>
			        	<option value="13" src="static/img/icons/make_spend/expense/13.png">Maintenance and Repair</option>
			        	<option value="14" src="static/img/icons/make_spend/expense/14.png">Other</option>
			        	<option value="15" src="static/img/icons/make_spend/expense/15.png">Property taxes</option>
			        	<option value="16" src="static/img/icons/make_spend/expense/16.png">Recreational</option>
			        	<option value="17" src="static/img/icons/make_spend/expense/17.png">Savings/investment</option>
			        	<option value="18" src="static/img/icons/make_spend/expense/18.png">Telephone</option>
			        	<option value="19" src="static/img/icons/make_spend/expense/19.png">Utilities</option>
			        </select>
				</div>
				<div>
					<input 
						type="text"
						name="expenseName"
						ng-model="addExpenseData.expenseName"
						class="aeNa {{(addExpenseValidate) ? (addExpenseForm.expenseName.$valid ? 'valid' : 'error') : ''}}" 
						placeholder='Name this expense, e.g. "AT&T phone"' 
						required 
						>
				</div>
			</div>
			<div class="col-lg-5">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<!-- <p class="content">Give us a short description of the expense. Include specifics, including partial account id <br />or identification number. For example,  AT&T account ending in 0012, Audi car <br />payment, etc. Your documents will be considered incomplete without this information.</p> -->
				<p class="aedesc">Provide a short description of the expense, including any existing payment terms. <br>
					Include specifics, including partial account id or identification number. <br>
					For example, Blue Shield Insurance Monthly Premium. <br>
					<a href="">Your documents will be incomplete without a description.</a></p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<textarea ng-model="addExpenseData.description" 
					name="description" 
					class="{{(addExpenseValidate) ? (addExpenseForm.description.$valid ? 'valid' : 'error') : ''}}"
					placeholder="Description goes here ..." 
					required></textarea>
			</div>
		</div>
		<!-- <div class="row">
			<div class="col-lg-12">
				<p>
					Did you acquire this expense in your marriage or separately?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<md-radio-group ng-model="addExpenseData.acquireExpense" 
						name="acquireDeby"
						class="{{(addExpenseValidate) ? (addAssetsForm.acquireDeby.$valid ? 'valid' : 'error') : ''}}"
						required>
				    	<md-radio-button value="Separately" class="md-primary">Separately</md-radio-button>
				    	<md-radio-button value="In marriage" class="md-primary">In marriage</md-radio-button>
				    </md-radio-group>
				</p>
			</div>
		</div> -->
		<div class="row">
			<div class="col-lg-8">
				<p class="discr_content">What date did you acquire this expense?</p>
			</div>
			<div class="col-lg-4">
				<!-- <div 
					datepicker 
					date-max-limit="{{today | date:'yyyy/MM/dd'}}" 
					date-format="MM/dd/yyyy"
					date-typer="false">
			        <input 
			        	ng-model="addExpenseData.acquireExpenseDate" 
			        	type="text" 
			        	class="angular-datepicker-input {{(addExpenseValidate) ? (addExpenseForm.acquireExpenseDate.$valid ? 'valid' : 'error') : ''}}"
			        	placeholder="MM/DD/YYYY"
			        	name="acquireExpenseDate" 
			        	required 
			        	/>
			    </div> -->
			    <input 
			    	type="text" 
			    	class="{{(addExpenseValidate) ? (addExpenseForm.acquireExpenseDate.$valid ? 'valid' : 'error') : ''}}"
			    	ng-model="addExpenseData.acquireExpenseDate" 
			    	name="acquireExpenseDate" 
			    	ui-date="{dateFormat: 'mm/dd/yy'}" 
			    	placeholder="MM/DD/YYYY" 
			    	required />
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<p class="discr_content">What is the estimated payment?</p>
			</div>
			<div class="col-lg-4">
				<input type="text" 
					name="estimation" 
					ng-model="addExpenseData.expenseEstimation" 
					class="{{(addExpenseValidate) ? (addExpenseForm.estimation.$valid ? 'valid' : 'error') : ''}}"
					validate="false" 
					restrict="reject"
					clean="true"
					limit="false"  
					mask="$99999999999999999"
					maxlength="20" 
					placeholder="$000,000,000" 
					required>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<p class="discr_content">How much of this expense are you paying?</p>
			</div>
			<div class="col-lg-4">
				<input type="text" 
					name="howMuchDebtGot" 
					ng-model="addExpenseData.howMuchYouPay" 
					class="{{(addExpenseValidate) ? (addExpenseForm.howMuchDebtGot.$valid ? 'valid' : 'error') : ''}}"
					validate="false" 
					restrict="reject"
					clean="true"
					limit="false"  
					mask="$99999999999999999"
					maxlength="20" 
					placeholder="$000,000,000" required>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<p class="discr_content">How much of this expense is your spouse paying?</p>
			</div>
			<div class="col-lg-4">
				<input type="text" 
					name="howMuchSpousePay"
					class="{{(addExpenseValidate) ? (addExpenseForm.howMuchSpousePay.$valid ? 'valid' : 'error') : ''}}"
					ng-model="addExpenseData.howMuchSpousePay"
					placeholder="$000,000,000"
					validate="false" 
					restrict="reject"
					clean="true"
					limit="false"  
					mask="$99999999999999999"
					maxlength="20" 
					required 
					>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-5">
				<p>
					How often do you pay these expenses?
				</p>
			</div>
			<div class="col-lg-7">
				<md-radio-group ng-model="addExpenseData.howOftenYouPay" 
					name="assetBelongto" 
					class="{{(addExpenseValidate) ? (addExpenseForm.assetBelongto.$valid ? 'valid' : 'error') : ''}}"
					required>
			    	<md-radio-button value="Monthly" class="md-primary">Monthly</md-radio-button>
			    	<md-radio-button value="Bi-weekly" class="md-primary">Bi-weekly</md-radio-button>
			    	<md-radio-button value="Weekly" class="md-primary">Weekly</md-radio-button>
			    	<md-radio-button value="Hourly" class="md-primary">Hourly</md-radio-button>
			    </md-radio-group>
			</div>
		</div>
		<!-- <div class="row">
			<div class="col-lg-12">
				<p>Do you have any additional details to add about this debt? For example, plans to close or transfer financial accounts, changing the titles, arrangements for dividing up loans...</p>
			</div>
		</div> -->
		<!-- <div class="row">
			<div class="col-lg-12">
				<textarea 
					ng-model="addExpenseData.additional"
					placeholder="Description goes here ..." 
				></textarea>
			</div>
		</div> -->
		<div class="row">
			<div class="col-lg-7">
				<label ng-if="addExpenseValidate && addExpenseForm.$invalid" class="error">Your form is missing information. Please check your responses.</label>
			</div>
			<div class="col-lg-5">
				<a href="" class="aeCn" ng-click="addNewClose('expense')">Cancel</a>
				<button ng-if="addExpenseForm.$valid" ng-click="addExpense(addExpenseData)" >Add Expense</button>
				<button ng-if="addExpenseForm.$invalid" ng-click="validateAddExpense()">Add Expense</button>
			</div>
		</div>
	</form>
</script>
<script type="text/ng-template" id="History">
	<div class="">
		<div class="historyHeadSec">
			<div class="divTable" style="width: 100%;">
				<div class="divTableHeading">
					<div class="divTableRow">
						<div class="divTableCell">
							<p>
								Date<br />
								<span>(added/edited)</span>
							</p>
						</div>
						<div class="divTableCell">
							<p>Item</p>
						</div>
						<div class="divTableCell">
							<p>Amount</p>
						</div>
					</div>
				</div>
			</div>	
		</div>
		<div class="historyLoopSec" ng-scrollbar>
			<div class="divTable" style="width: 100%;">
				<div class="divTableBody">
					<div class="divTableRow" ng-repeat="list in history" ng-click="edit(list.id, list.type)">
						<div class="divTableCell">
							<p>{{list.updated}}</p>
						</div>
						<div class="divTableCell">
							<p>{{list.type == 'income' ? incomeTypeList[list.incomeType].title : expenseTypeList[list.expenseType].title }}</p>
						</div>
						<div class="divTableCell">
							<p>
								{{list.type == 'income' ? (list.howMuchIncome | currency:"$":0) : '-'+(list.expenseEstimation | currency:"$":0) }}
							</p>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="editPopUpIncome">
	<div class="editPopUpSecAssets">
		<form name="editIncomeForm" novalidate>
			<!-- <div class="row">
				<div class="col-lg-12">
					<p>
						Who does the income belong to?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<md-radio-group ng-model="editIncomeData.incomeBelongto" 
							name="assetBelongto" 
							class="{{(editIncomeForm.incomeBelongto.$touched) ? (editIncomeForm.incomeBelongto.$valid ? 'valid' : 'error') : (conterror) ? (editIncomeForm.incomeBelongto.$valid ? 'valid' : 'error') : ''}}"
							required>
					    	<md-radio-button value="Me" class="md-primary">Me</md-radio-button>
					    	<md-radio-button value="Spouse" class="md-primary">Spouse</md-radio-button>
					    </md-radio-group>
					</p>				
				</div>
			</div> -->
			<div class="row">
				<div class="col-lg-7">
					<div class="{{(editIncomeForm.incomeType.$touched) ? (editIncomeForm.incomeType.$valid ? 'valid' : 'error') : (conterror) ? (editIncomeForm.incomeType.$valid ? 'valid' : 'error') : ''}}">

						<!-- <md-select placeholder="What type of income?" ng-model="editIncomeData.incomeType" data-md-container-class="selectdemoSelectHeader" required>
				            <md-option ng-value="$index" ng-repeat="list in incomeTypeList">
				              <img height="41px" width="41px" src="static/img/icons/make_spend/income/{{$index}}.png">
				              <span>
				              	{{list.title}}
				              	<span ng-if="list.subtitle!=''" class="subtitle">{{$first ? '' : list.subtitle}}
				              </span>
				              
				            </md-option>
				        </md-select>	 -->
				        <select custom-select="" ng-model="editIncomeData.incomeType" name="incomeType" ng-required="true" required>
				        	<option value="" src="">What type of income?</option>
				        	<option value="1" src="static/img/icons/make_spend/income/1.png">Salary or wages</option>
				        	<option value="2" src="static/img/icons/make_spend/income/2.png">Overtime</option>
				        	<option value="3" src="static/img/icons/make_spend/income/3.png">Commissions or bonus</option>
				        	<option value="4" src="static/img/icons/make_spend/income/4.png">Public assistance</option>
				        	<option value="5" src="static/img/icons/make_spend/income/5.png">Spousal support</option>
				        	<option value="6" src="static/img/icons/make_spend/income/6.png">Pension/retirement fund payments</option>
				        	<option value="7" src="static/img/icons/make_spend/income/7.png">Social security retirement</option>
				        	<option value="8" src="static/img/icons/make_spend/income/8.png">Disability</option>
				        	<option value="9" src="static/img/icons/make_spend/income/9.png">Unemployment compensation</option>
				        	<option value="10" src="static/img/icons/make_spend/income/10.png">Worker's compensation</option>
				        	<option value="11" src="static/img/icons/make_spend/income/11.png">Other</option>
				        	<option value="12" src="static/img/icons/make_spend/income/12.png">Self-employment</option>
				        </select>
					</div>
					<div>
						<input 
							type="text" 
							class="aiNa" 
							name="incomeName" 
							placeholder='Name this income, e.g. "Acme Inc. salary"'
							ng-model="editIncomeData.incomeName"
							required>
					</div>
				</div>
				<div class="col-lg-5">
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<!-- <p class="content">Give us a short description of the income. Include specifics, including employer name or <br />tax ID. For example, Apple Inc. W2 salary, or 1099 tax ID ending #1345. Your <br />documents will be considered incomplete without this information.</p> -->
					<p class="aidesc">Provide a short descritopn of the income, including any existing payment terms. <br>
						Include specifics, includeing partial account id or identification number. <br>
						For example, Apple Inc. W2 salary. <br>
						<a href="">Your documents will be incomplete without a description.</a>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<textarea ng-model="editIncomeData.description" 
						name="description" 
						class="{{(editIncomeForm.description.$touched) ? (editIncomeForm.description.$valid ? 'valid' : 'error') : (conterror) ? (editIncomeForm.description.$valid ? 'valid' : 'error') : ''}}" 
						placeholder="Description goes here ..." 
						required
						></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<p class="discr_content">How much is this income?</p>
				</div>
				<div class="col-lg-4">
					<input type="text"
						name="howMuchIncome" 
						class="{{(editIncomeForm.howMuchIncome.$touched) ? (editIncomeForm.howMuchIncome.$valid ? 'valid' : 'error') : (conterror) ? (editIncomeForm.howMuchIncome.$valid ? 'valid' : 'error') : ''}}" 
						ng-model="editIncomeData.howMuchIncome" 
						placeholder="$000,000,000" 
						validate="false" 
						restrict="reject"
						clean="true"
						limit="false"  
						mask="$99999999999999999"
						required>
					
				</div>
			</div>
			<div class="row">
				<div class="col-lg-5">
					<p>How often is this income paid?</p>
				</div>
				<div class="col-lg-7">
					<md-radio-group ng-model="editIncomeData.howOften" 
						name="assetBelongto" 
						class="{{(editIncomeForm.incomeBelongto.$touched) ? (editIncomeForm.incomeBelongto.$valid ? 'valid' : 'error') : (conterror) ? (editIncomeForm.incomeBelongto.$valid ? 'valid' : 'error') : ''}}"
						required>
				    	<md-radio-button value="Monthly" class="md-primary">Monthly</md-radio-button>
				    	<md-radio-button value="Bi-weekly" class="md-primary">Bi-weekly</md-radio-button>
				    	<md-radio-button value="Weekly" class="md-primary">Weekly</md-radio-button>
				    	<md-radio-button value="Hourly" class="md-primary">Hourly</md-radio-button>
				    </md-radio-group>
				</div>
			</div>
			<!-- <div class="row">
				<div class="col-lg-12">
					<p>Do you have any additional details to add about this asset? For example, plans to close <br />or transfer financial accounts, changing the title on cars, arrangements for dividing up <br />personal items like furniture.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<textarea 
						ng-model="editIncomeData.additionalDetails" 
						name="additional" 
						placeholder="Additional details go here ...">
					</textarea>
				</div>
			</div> -->
			<div class="row">
				<div class="col-lg-12">
					<button ng-click="editIncome(editIncomeData)">Update Income</button>
					<!--<button ng-if="editIncomeForm.$invalid" ng-click="continue2()">Update Income</button>-->
				</div>
			</div>
		</form>
	</div>
</script>
<script type="text/ng-template" id="editPopUpExpense">
	<div class="editPopUpSecDebt">
		<form name="editExpenseForm" novalidate>
			<!-- <div class="row">
			<div class="col-lg-12">
				<p>
					Who does the expense belong to?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<md-radio-group ng-model="editExpenseData.belongTo" 
						name="belongTo"
						class="{{(editExpenseForm.belongTo.$touched) ? (editExpenseForm.belongTo.$valid ? 'valid' : 'error') : (conterror) ? (editExpenseForm.belongTo.$valid ? 'valid' : 'error') : ''}}"
						required>
				    	<md-radio-button value="Me" class="md-primary">Me</md-radio-button>
				    	<md-radio-button value="Spouse" class="md-primary">Spouse</md-radio-button>
				    </md-radio-group>
				</p>				
			</div>
		</div> -->
		<div class="row">
			<div class="col-lg-7">
				<div class="{{(editExpenseForm.debtType.$touched) ? (editExpenseForm.debtType.$valid ? 'valid' : 'error') : (conterror) ? (editExpenseForm.debtType.$valid ? 'valid' : 'error') : ''}}">
					<!-- <md-select placeholder="What type of expense?" ng-model="editExpenseData.expenseType" data-md-container-class="selectdemoSelectHeader" required>
			            <md-option ng-value="$index" ng-repeat="list in expenseTypeList">
			              <img height="41px" width="41px" src="static/img/icons/make_spend/expense/{{$index}}.png">
			              <span>{{list.title}}</span>
			            </md-option>
			        </md-select>	 -->
			        <select custom-select="" ng-model="editExpenseData.expenseType" name="expenseType" ng-required="true" required>
			        	<option value="" src="">What type of expense?</option>
			        	<option value="1" src="static/img/icons/make_spend/expense/1.png">Auto</option>
			        	<option value="2" src="static/img/icons/make_spend/expense/2.png">Charitable contributions</option>
			        	<option value="3" src="static/img/icons/make_spend/expense/3.png">Child care</option>
			        	<option value="4" src="static/img/icons/make_spend/expense/4.png">Clothes</option>
			        	<option value="5" src="static/img/icons/make_spend/expense/5.png">Education</option>
			        	<option value="6" src="static/img/icons/make_spend/expense/6.png">Groceries/household</option>
			        	<option value="7" src="static/img/icons/make_spend/expense/7.png">Home</option>
			        	<option value="8" src="static/img/icons/make_spend/expense/8.png">Health-care cost not paid insurance</option>
			        	<option value="9" src="static/img/icons/make_spend/expense/9.png">Homeowner's insurance</option>
			        	<option value="10" src="static/img/icons/make_spend/expense/10.png">Installment payments</option>
			        	<option value="11" src="static/img/icons/make_spend/expense/11.png">Insurance</option>
			        	<option value="12" src="static/img/icons/make_spend/expense/12.png">Laundry/cleaning</option>
			        	<option value="13" src="static/img/icons/make_spend/expense/13.png">Maintenance and Repair</option>
			        	<option value="14" src="static/img/icons/make_spend/expense/14.png">Other</option>
			        	<option value="15" src="static/img/icons/make_spend/expense/15.png">Property taxes</option>
			        	<option value="16" src="static/img/icons/make_spend/expense/16.png">Recreational</option>
			        	<option value="17" src="static/img/icons/make_spend/expense/17.png">Savings/investment</option>
			        	<option value="18" src="static/img/icons/make_spend/expense/18.png">Telephone</option>
			        	<option value="19" src="static/img/icons/make_spend/expense/19.png">Utilities</option>
			        </select>
				</div>
				<div>
					<input 
						type="text"
						name="expenseName"
						ng-model="editExpenseData.expenseName"
						class="aeNa" 
						placeholder='Name this expense, e.g. "AT&T phone"' 
						required 
						>
				</div>
			</div>
			<div class="col-lg-5">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<!-- <p class="content">Give us a short description of the expense. Include specifics, including partial account id <br />or identification number. For example,  AT&T account ending in 0012, Audi car <br />payment, etc. Your documents will be considered incomplete without this information.</p> -->
				<p class="aedesc">Provide a short description of the expense, including any existing payment terms. <br>
					Include specifics, including partial account id or identification number. <br>
					For example, Blue Shield Insurance Monthly Premium. <br>
					<a href="">Your documents will be incomplete without a description.</a></p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<textarea ng-model="editExpenseData.description" 
					name="description" 
					class="{{(editExpenseForm.description.$touched) ? (editExpenseForm.description.$valid ? 'valid' : 'error') : (conterror) ? (editExpenseForm.description.$valid ? 'valid' : 'error') : ''}}"
					placeholder="Description goes here ..." 
					required></textarea>
			</div>
		</div>
		<!-- <div class="row">
			<div class="col-lg-12">
				<p>
					Did you acquire this expense in your marriage or separately?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<md-radio-group ng-model="editExpenseData.acquireExpense" 
						name="acquireDeby"
						class="{{(editExpenseForm.acquireDeby.$touched) ? (editExpenseForm.acquireDeby.$valid ? 'valid' : 'error') : (conterror) ? (editExpenseForm.acquireDeby.$valid ? 'valid' : 'error') : ''}}"
						required>
				    	<md-radio-button value="Separately" class="md-primary">Separately</md-radio-button>
				    	<md-radio-button value="In marriage" class="md-primary">In marriage</md-radio-button>
				    </md-radio-group>
				</p>
			</div>
		</div> -->
		<div class="row">
			<div class="col-lg-8">
				<p class="discr_content">What date did you acquire this expense?</p>
			</div>
			<div class="col-lg-4">
				<!-- <div 
					datepicker 
					date-max-limit="{{today | date:'yyyy/MM/dd'}}" 
					date-format="MM/dd/yyyy"
					date-typer="false">
			        <input 
			        	ng-model="editExpenseData.acquireExpenseDate" 
			        	type="text" 
			        	class="angular-datepicker-input"
			        	placeholder="MM/DD/YYYY"
			        	/>
			    </div> -->
			    <input 
			    	type="text" 
			    	class="{{(addExpenseValidate) ? (editExpenseForm.acquireExpenseDate.$valid ? 'valid' : 'error') : ''}}"
			    	ng-model="editExpenseData.acquireExpenseDate" 
			    	name="acquireExpenseDate" 
			    	ui-date="{dateFormat: 'mm/dd/yy'}" 
			    	placeholder="MM/DD/YYYY" 
			    	required />
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<p class="discr_content">What is the estimated payment?</p>
			</div>
			<div class="col-lg-4">
				<input type="text" 
					name="estimation" 
					ng-model="editExpenseData.expenseEstimation" 
					class="{{(editExpenseForm.estimation.$touched) ? (editExpenseForm.estimation.$valid ? 'valid' : 'error') : (conterror) ? (editExpenseForm.estimation.$valid ? 'valid' : 'error') : ''}}"
					validate="false" 
					restrict="reject"
					clean="true"
					limit="false"  
					mask="$99999999999999999"
					placeholder="$000,000,000"
					required>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<p class="discr_content">How much of this expense are you paying?</p>
			</div>
			<div class="col-lg-4">
				<input type="text" 
					name="howMuchDebtGot" 
					ng-model="editExpenseData.howMuchYouPay" 
					class="{{(editExpenseForm.howMuchDebtGot.$touched) ? (editExpenseForm.howMuchDebtGot.$valid ? 'valid' : 'error') : (conterror) ? (editExpenseForm.howMuchDebtGot.$valid ? 'valid' : 'error') : ''}}"
					validate="false" 
					restrict="reject"
					clean="true"
					limit="false"  
					mask="$99999999999999999"
					placeholder="$000,000,000" required>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<p class="discr_content">How much of this expense is your spouse paying?</p>
			</div>
			<div class="col-lg-4">
				<input type="text" 
					name=""
					ng-model="editExpenseData.howMuchSpousePay"
					validate="false" 
					restrict="reject"
					clean="true"
					limit="false"  
					mask="$99999999999999999"
					required 
					>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-5">
				<p>
					How often do you pay these expenses?
				</p>
			</div>
			<div class="col-lg-7">
				<md-radio-group ng-model="editExpenseData.howOftenYouPay" 
					name="assetBelongto" 
					required>
			    	<md-radio-button value="Monthly" class="md-primary">Monthly</md-radio-button>
			    	<md-radio-button value="Bi-weekly" class="md-primary">Bi-weekly</md-radio-button>
			    	<md-radio-button value="Weekly" class="md-primary">Weekly</md-radio-button>
			    	<md-radio-button value="Hourly" class="md-primary">Hourly</md-radio-button>
			    </md-radio-group>
			</div>
		</div>
		<!-- <div class="row">
			<div class="col-lg-12">
				<p>Do you have any additional details to add about this debt? For example, plans to close or transfer financial accounts, changing the titles, arrangements for dividing up loans...</p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<textarea 
					ng-model="editExpenseData.additional"
					placeholder="Description goes here ..." 
				></textarea>
			</div>
		</div> -->
		<div class="row">
			<div class="col-lg-12">
				<button ng-click="editExpense(editExpenseData)" >Edit Expense</button>
			</div>
		</div>
		</form>
	</div>
</script>
<script type="text/ng-template" id="haveOweReview">
	<div>
		
	</div>
</script>