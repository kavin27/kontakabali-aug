<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="process_bar">
	<div class="container">
		<div class="row">
			<div>
				<ul class="process_bar_status">
					<li ng-repeat="first_stepA in first_step" class="{{($index == i) ? 'current' : ''}} {{first_stepA.status}}"> 
						<a href="{{first_stepA.url}}">
							<style type="text/css">
								.process_status li .icon, .process_bar_status > li .icon.iconbgcolor{{$index}}{
									background-color: {{first_stepA.color}};
								}
							</style>
							<div class="icon iconbgcolor{{$index}}">
								<img ng-src="{{first_stepA.icon}}" title="{{first_stepA.title}}">
								<span class="line"></span>
							</div>
						</a>
						<p>{{first_stepA.title}}</p>
						<ul>
							<style type="text/css">
								.process_bar_status > li ul li.innercompletebgcolor{{$index}}{
									background-color:{{first_stepA.color}};
									margin-right: 0;
								}
							</style>
							<li ng-repeat="first_stepAinner in first_stepA.inner" class="innercompletebgcolor{{$parent.$index}} {{($index == j) ? 'current' : ''}} {{first_stepAinner.status}}" >
								
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
											"
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
											"
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
		<div ng-if="skipNav" class="row">
			<div class="col-lg-12">
				<div class="formNav">
					<a href="" ng-click="goback()" class="previous">Previous</a>		
					<a href="" ng-if="myForm.$valid" ng-click="continue()" class="next">
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
					<a href="" ng-if="myForm.$invalid" ng-click="continue2()" class="next">
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
				<ng-include src="currentStep" ng-init="loadUserData(formPosition)">
		    		    
		    	</ng-include>	
			</form>
			<div id="upload_process" style="display: none;">
    			<div class="popup-inner1">
    				<div class="popup_sec1">
						<div class="row">
		    				<div class="col-lg-12">
		    					<h3>Upload queue</h3>
			                    <p>Queue length: {{ uploader.queue.length }}</p>
			                    <table class="table">
			                        <thead>
			                            <tr>
			                                <th width="25%">Name</th>
			                                <th ng-show="uploader.isHTML5">Size</th>
			                                <th ng-show="uploader.isHTML5">Progress</th>
			                                <th>Status</th>
			                                <th>Actions</th>
			                            </tr>
			                        </thead>
			                        <tbody>
			                            <tr ng-repeat="item in uploader.queue">
			                                <td><strong>{{ item.file.name }}</strong></td>
			                                <td ng-show="uploader.isHTML5" nowrap>{{ item.file.size/1024/1024|number:2 }} MB</td>
			                                <td ng-show="uploader.isHTML5">
			                                    <div class="progress" style="margin-bottom: 0; width: 135px; height: 20px; margin-top: 5px;">
			                                        <div class="progress-bar" role="progressbar" ng-style="{ 'width': item.progress + '%' }"></div>
			                                    </div>
			                                </td>
			                                <td class="text-center">
			                                    <span ng-show="item.isSuccess"><i class="glyphicon glyphicon-ok"></i></span>
			                                    <span ng-show="item.isCancel"><i class="glyphicon glyphicon-ban-circle"></i></span>
			                                    <span ng-show="item.isError"><i class="glyphicon glyphicon-remove"></i></span>
			                                </td>
			                                <td nowrap>
			                                    <button type="button" class="btn btn-success btn-xs" ng-click="item.upload()" ng-disabled="item.isReady || item.isUploading || item.isSuccess">
			                                        <span class="glyphicon glyphicon-upload"></span> Upload
			                                    </button>
			                                    <button type="button" class="btn btn-warning btn-xs" ng-click="item.cancel()" ng-disabled="!item.isUploading">
			                                        <span class="glyphicon glyphicon-ban-circle"></span> Cancel
			                                    </button>
			                                    <button type="button" class="btn btn-danger btn-xs" ng-click="item.remove()" ng-disabled="item.isSuccess">
			                                        <span class="glyphicon glyphicon-trash"></span> Remove
			                                    </button>
			                                </td>
			                            </tr>
			                        </tbody>
			                    </table>
		    				</div>
		    			</div>    	
		    			<a class="popup-close" data-popup-close="popup-1" ng-click="popupClose2()">x</a>				
    				</div>
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
<script type="text/ng-template" id="holidayPop">
	<div class="HolidayPopup">
		<div>
			<button ng-click="submitHolidy(holidayList)">Save & Continue</button>
		</div>
		<div>
			<h1>Holidays</h1>
			<p>Create a proposed holiday schedule for you and your spouse. Click the empty boxes to designate who will take that holiday.  Leave holidays blank that do not pertain to you and they will not be added to the calendar. You can come back and modify this at any time.</p>
		</div>
		<v-accordion id="accordionA" class="vAccordion--default" control="accordionA">
			<v-pane id="{{ ::pane.id }}" ng-repeat="pane in holidayList" expanded="$first">
				<v-pane-header id="{{ ::pane.id }}-header" aria-controls="{{ ::pane.id }}-content">
					<h4 id="acc_title" data-width="" >
	                	<!--<span class="per_are"></span> -->
						<div class="content">{{ ::pane.title}}</div>
	                </h4>
				</v-pane-header>

				<v-pane-content id="{{ ::pane.id }}-content" aria-labelledby="{{ ::pane.id }}-header">
					<div class="holidayContentSec">
						<table>
							<thead>
								<tr>
									<td>{{$index == 2 ? 'Name' : 'Holiday'}}</td>
									<td>Date & Time</td>
									<td>Every <br/>Year</td>
									<td>Odd <br/>Years</td>
									<td style="text-align: center;">Even <br/>Years</td>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="listVal in pane.list">
									<td>
										{{pane.dynamic ? '' : listVal.text}}
										<input 
											ng-if="pane.dynamic" 
											type="text" 
											name="" 
											placeholder="Name" 
											class="personName" 
											ng-model="listVal.text"/>
									</td>
									<td>
										<div 
											class="holidayDP" 
			            					datepicker 
			            					date-format="MM/dd/yyyy"
			            					date-typer="false">
									        <input 
									        	ng-model="listVal.date.start[0]" 
									        	type="text" 
									        	class="angular-datepicker-input" 
									        	placeholder="mm/dd/yyy" 
									        />
									    </div>
										<input 
											type="text" 
											name="" 
											ng-model="listVal.date.start[1]"
											placeholder="12:00 AM">
										<span>to</span>
										<input 
											type="text" 
											name="" 
											ng-model="listVal.date.end[1]"
											placeholder="12:00 PM">
										<div 
											class="holidayDP" 
			            					datepicker 
			            					date-format="MM/dd/yyyy"
			            					date-typer="false">
									        <input 
									        	ng-model="listVal.date.end[0]" 
									        	type="text" 
									        	class="angular-datepicker-input" 
									        	placeholder="mm/dd/yyy" 
									        />
									    </div>
									</td>
									<td>
										<select ng-model="listVal.current">
											<option value="Clear">Clear</option>
											<option value="Petitioner">Petitioner</option>
											<option value="Respondent">Respondent</option>
										</select>
									</td>
									<td>
										<select ng-model="listVal.odd" ng-disabled="listVal.current">
											<option value="Clear">Clear</option>
											<option value="Petitioner">Petitioner</option>
											<option value="Respondent">Respondent</option>
										</select>
									</td>
									<td>
										<select  ng-model="listVal.even" ng-disabled="listVal.current">
											<option value="Clear">Clear</option>
											<option value="Petitioner">Petitioner</option>
											<option value="Respondent">Respondent</option>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
						<div ng-if="pane.dynamic" class="addBtnSec">
							<button ng-click="kidsaddress(pane.list)">Add Birthday</button>
						</div>
					</div>
				</v-pane-content>
			</v-pane>
		</v-accordion>
	</div>
</script>
<script type="text/ng-template" id='myInfo1'>
    <div class="row">
    	<div class="BI_form1">
			<h2 class="BI_h1">My Info</h2>
			<p class="BI_p">Why are you getting divorced?</p>
		</div>
		<div class="rd_sec">
			<md-radio-group ng-model="data.myInfo.why"
				class="{{(myForm.why.$touched) ? (myForm.why.$valid ? 'valid' : 'error') : (conterror) ? 'error' : 'valid'}}"
				name="why" 
				required>
			    <div class="rd_lt">  
			    	<md-radio-button value="We can’t work out our disagreements" class="md-primary">We can’t work out our disagreements</md-radio-button>
			    </div>
			    <div class="rd_rt">  
			    	<md-radio-button value="One of us is permanently legally incapacitated" class="md-primary">One of us is permanently legally incapacitated</md-radio-button>
			    </div>
			    <div class="rd_full">  
			    	<md-radio-button value="Other" class="md-primary">Other</md-radio-button>  
			    	<input 
			    		ng-if="data.myInfo.why == 'Other'"
			    		type="text" 
			    		ng-model="data.myInfo.whyOther"
			    		class="{{(myForm.whyOther.$touched) ? (myForm.whyOther.$valid ? 'valid' : 'error') : (conterror) ? 'error' : ''}}"
			    		name="whyOther" 
			    		maxlength="200" 
			    		placeholder="Enter Here"
			    		required 
			    	>
			    </div>
		    </md-radio-group>
			
		</div>
    </div>
</script>
<script type="text/ng-template" id="myInfo2">
	<div class="row">
		<div class="BI_form1">
			<h2 class="BI_h1">My Info</h2>
		</div>
		<div class="my_in_form">
			<div class="my_in_frm_lt">Name <br>
				<input type="text" 
					ng-model="data.myInfo.fname" 
					class="{{(myForm.myfirstName.$touched) ? (myForm.myfirstName.$valid ? 'valid' : 'error') : (conterror) ? (myForm.myfirstName.$valid ? 'valid' : 'error') : ''}} " 
					name="myfirstName" alphapet 
					placeholder="First Name" 
					id="fname" 
					maxlength="35" 
					required>
			</div>
			<div class="my_in_frm_rt"><br>
				<input type="text" 
					ng-model="data.myInfo.lname"  
					name="mylastName" 
					class="{{(myForm.mylastName.$touched) ? (myForm.mylastName.$valid ? 'valid' : 'error') : (conterror) ? (myForm.mylastName.$valid ? 'valid' : 'error') : ''}}" 
					alphapet 
					id="lname" 
					placeholder="Last Name" 
					maxlength="35" 
					required>
			</div>					
			<div class="my_in_frm_lt">Birth Date: <br>
				<input type="text" 
					ng-model="data.myInfo.dob[0]"
					class="mm_in {{(myForm.mydobMonth.$touched) ? (myForm.mydobMonth.$valid ? 'valid' : 'error') : (conterror) ? (myForm.mydobMonth.$valid ? 'valid' : 'error') : ''}}" 
					mask="19" 
					restrict="reject" 
					name="mydobMonth" 
					placeholder="MM" 
					required>
				<input type="text" 
					class="mm_in1 {{(myForm.mydobDate.$touched) ? (myForm.mydobDate.$valid ? 'valid' : 'error') : (conterror) ? (myForm.mydobDate.$valid ? 'valid' : 'error') : ''}}" 
					ng-model="data.myInfo.dob[1]" 
					mask="39" 
					restrict="reject" 
					name="mydobDate" 
					placeholder="DD" 
					maxlength="2" 
					required>
				<input  type="text" 
					class="mm_in2 {{(myForm.mydobYear.$touched) ? (myForm.mydobYear.$valid ? 'valid' : 'error') : (conterror) ? (myForm.mydobYear.$valid ? 'valid' : 'error') : ''}}" 
					ng-model="data.myInfo.dob[2]" 
					mask="9999" 
					restrict="reject" 
					name="mydobYear" 
					placeholder="YYYY" 
					maxlength="4" 
					required>
			</div>
			<div class="my_in_frm_rt">Gender:<br>
				<div class="rd_btn25">
					<md-radio-group ng-model="data.myInfo.gender" 
						name="myGender"
						class="{{(myForm.myGender.$touched) ? (myForm.myGender.$valid ? 'valid' : 'error') : (conterror) ? (myForm.myGender.$valid ? 'valid' : 'error') : ''}}" 
						required>
						<md-radio-button value="M" ng-checked="data.myInfo.gender == 'M'" class="md-primary" >Male</md-radio-button>
						<md-radio-button value="F" ng-checked="data.myInfo.gender == 'F'" class="md-primary" >Female</md-radio-button>
					</md-radio-group>
               </div>
		    </div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="myInfo3">
	<div class="row">
		<div class="BI_form1">
			<h2 class="BI_h1">My Info</h2>
			<p class="BI_p">
				
			</p>
		</div>
		<div class="my_in_form">
			<div class="my_in_frm_lt1">Address <br>
				<input type="text" 
					ng-model="data.myInfo.street"
					class="{{(myForm.myaddressStreet.$touched) ? (myForm.myaddressStreet.$valid ? 'valid' : 'error') : (conterror) ? (myForm.myaddressStreet.$valid ? 'valid' : 'error') : ''}}" 
					name="myaddressStreet" 
					ng-value="'{{data.myinfo.street}}'" 
					placeholder="Street" 
					maxlength="100" 
					required>
			</div>
			<div class="my_in_frm_rt1 {{(myForm['myaddressState'].$touched) ? (myForm['myaddressState'].$valid ? 'valid' : 'error') : (conterror) ? (myForm['myaddressState'].$valid ? 'valid' : 'error') : ''}}"><br>
				<select ui-select2 
					ng-model="data.myInfo.state" 
					name="myaddressState" 
					class="input_field {{(myForm.myaddressState.$touched) ? (myForm.myaddressState.$valid ? 'valid' : 'error') : (conterror) ? (myForm.myaddressState.$valid ? 'valid' : 'error') : ''}}"  
					required >
					<option value="">State</option>
					<option value="California">California</option>
				</select>
			</div>					
			<div class="my_in_frm_lt1"><br>
				<input type="text" 
					ng-model="data.myInfo.city"
					class="{{(myForm.myaddressCity.$touched || conterror) ? (myForm.myaddressCity.$valid ? 'valid' : 'error') : ''}}" 
					name="myaddressCity" 
					alphapet 
					ng-value="'{{data.myinfo.city}}'" 
					placeholder="City" 
					maxlength="50" 
					required>
			</div>
			<div class="my_in_frm_rt1"><br>
				<input type="text" 
					ng-model="data.myInfo.zipcode"
					class="{{(myForm.myaddressZip.$touched) ? (myForm.myaddressZip.$valid ? 'valid' : 'error') : (conterror) ? (myForm.myaddressZip.$valid ? 'valid' : 'error') : ''}}" 
					name="myaddressZip" 
					mask="99999" 
					restrict="reject" 
					ng-value="{{data.myinfo.zipcode}}" 
					placeholder="Zip Code" 
					maxlength="6" 
					required>
			</div>
			<div class="my_in_frm_lt1"><br>
				<input type="text" 
					ng-model="data.myInfo.phone"
					class="{{(myForm.myPhone.$touched) ? (myForm.myPhone.$valid ? 'valid' : 'error') : (conterror) ? (myForm.myPhone.$valid ? 'valid' : 'error') : ''}}" 
					name="myPhone" 
					mask="(999) 999-9999" 
					restrict="reject" 
					placeholder="Phone Number"
					clean="true" 
					required>
			</div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="myInfo4">
	<div class="row">
		<div class="BI_form1">
			<h2 class="BI_h1">My Info</h2>
		</div>
		<div class="my_in_form">
			<div class="my_in_frm_lt1"><br>
				<input type="text" 
					ng-model="data.myInfo.job" 
					class="{{(myForm.myJob.$touched) ? (myForm.myJob.$valid ? 'valid' : 'error') : (conterror) ? (myForm.myJob.$valid ? 'valid' : 'error') : ''}}" 
					name="myJob" 
					alphapet 
					ng-value="'{{data.myinfo.job}}'" 
					placeholder="Job Title" 
					maxlength="100" 
					required>
			</div>					
			<div class="my_in_frm_rt1"><br>
				<input type="text" 
					ng-model="data.myInfo.income"
					class="{{(myForm.MyIncome.$touched) ? (myForm.MyIncome.$valid ? 'valid' : 'error') : (conterror) ? (myForm.MyIncome.$valid ? 'valid' : 'error') : ''}}" 
					name="MyIncome" 
					placeholder="Annual Income" 
					currency-input
					field="data.myInfo.income"
					required>
			</div>
		</div>
	</div>
</script>

<script type="text/ng-template" id="spouseInfo1">
	<div class="row">
		<div class="BI_form1">
			<h2 class="BI_h1">Spouse’s Info</h2>
		</div>
		<div class="my_in_form">
			<div class="my_in_frm_lt">Name <br>
				<input type="text" 
					ng-model="data.spouseinfo.fname"
					alphapet 
					ng-value="'{{data.spouseinfo.first_name}}'" 
					name="spousefirstName" 
					class="{{(myForm.spousefirstName.$touched) ? (myForm.spousefirstName.$valid ? 'valid' : 'error') : (conterror) ? (myForm.spousefirstName.$valid ? 'valid' : 'error') : '' }}" 
					placeholder="First Name" 
					maxlength="35"
					required>
			</div>
			<div class="my_in_frm_rt"><br>
				<input type="text" 
					ng-model="data.spouseinfo.lname"
					class="{{(myForm.spouselastName.$touched) ? (myForm.spouselastName.$valid ? 'valid' : 'error') : (conterror) ? (myForm.spouselastName.$valid ? 'valid' : 'error') : ''}}" 
					alphapet 
					ng-value="'{{data.spouseinfo.last_name}}'" 
					name="spouselastName" 
					placeholder="Last Name" 
					maxlength="35"
					required>
			</div>					
			<div class="my_in_frm_lt">Birth Date: <br>
				<input 
					ng-model="data.spouseinfo.dob[0]"
					class="mm_in {{(myForm.spousedobMonth.$touched) ? (myForm.spousedobMonth.$valid ? 'valid' : 'error') : (conterror) ? (myForm.spousedobMonth.$valid ? 'valid' : 'error') : ''}}" 
					type="text" 
					mask="19" 
					restrict="reject" 
					name="spousedobMonth" 
					placeholder="MM" 
					maxlength="2"
					required>
				<input 
					ng-model="data.spouseinfo.dob[1]"
					class="mm_in1 {{(myForm.spousedobDate.$touched) ? (myForm.spousedobDate.$valid ? 'valid' : 'error') : (conterror) ? (myForm.spousedobDate.$valid ? 'valid' : 'error') : ''}}" 
					type="text" 
					mask="39" 
					restrict="reject" 
					name="spousedobDate" 
					placeholder="DD" 
					maxlength="2"
					required>
				<input 
					ng-model="data.spouseinfo.dob[2]" 
					class="mm_in2 {{(myForm.spousedobYear.$touched) ? (myForm.spousedobYear.$valid ? 'valid' : 'error') : (conterror) ? (myForm.spousedobYear.$valid ? 'valid' : 'error') : ''}}" 
					type="text" 
					mask="9999" 
					restrict="reject" 
					name="spousedobYear" 
					placeholder="YYYY" 
					maxlength="4" 
					required>
			</div>
			<div class="my_in_frm_rt">Gender:<br>
				<div class="rd_btn25">
					<md-radio-group ng-model="data.spouseinfo.gender" 
						class="{{(myForm.spouseGender.$touched) ? (myForm.spouseGender.$valid ? 'valid' : 'error') : (conterror) ? (myForm.spouseGender.$valid ? 'valid' : 'error') : ''}}" 
						name="spouseGender"
						required>
						<md-radio-button value="M" class="md-primary" >Male</md-radio-button>
						<md-radio-button value="F" class="md-primary" >Female</md-radio-button>
					</md-radio-group>
               </div>
		    </div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="spouseInfo2">
	<div class="row">
		<div class="BI_form1">
			<h2 class="BI_h1">Spouse’s Info</h2>
			<p class="BI_p">
				
			</p>
		</div>
		<div class="my_in_form">
			<div class="my_in_frm_lt1">Address <br>
				<input type="text" 
					ng-model="data.spouseinfo.street" 
					ng-value="'{{data.spouseinfo.street}}'" 
					class="{{(myForm.spouseaddressStreet.$touched) ? (myForm.spouseaddressStreet.$valid ? 'valid' : 'error') : (conterror) ? (myForm.spouseaddressStreet.$valid ? 'valid' : 'error') : ''}}" 
					name="spouseaddressStreet" 
					placeholder="Street" 
					maxlength="100"
					required>
			</div>
			<div class="my_in_frm_rt1 {{(myForm['myaddressState'].$touched) ? (myForm['myaddressState'].$valid ? 'valid' : 'error') : (conterror) ? (myForm['myaddressState'].$valid ? 'valid' : 'error') : ''}}"><br>
				<select ui-select2 
					ng-model="data.spouseinfo.state" 
					class="input_field"
					name="spouseaddressState"
					class="{{(myForm.spouseaddressState.$touched) ? (myForm.spouseaddressState.$valid ? 'valid' : 'error') : (conterror) ? (myForm.spouseaddressState.$valid ? 'valid' : 'error') : ''}}" 
					required>
					<option value="">State</option>
					<option value="California">California</option>
				</select>
			</div>					
			<div class="my_in_frm_lt1">
				<br>
				<input type="text" 
					ng-model="data.spouseinfo.city" 
					alphapet 
					ng-value="'{{data.spouseinfo.city}}'" 
					class="{{(myForm.spouseaddressCity.$touched) ? (myForm.spouseaddressCity.$valid ? 'valid' : 'error') : (conterror) ? (myForm.spouseaddressCity.$valid ? 'valid' : 'error') : ''}}" 
					name="spouseaddressCity" 
					placeholder="City" 
					maxlength="50"
					required>
			</div>
			<div class="my_in_frm_rt1">
				<br>
				<input type="text" 
					ng-model="data.spouseinfo.zipcode" 
					mask="99999" 
					restrict="reject" 
					ng-value="{{data.spouseinfo.zipcode}}" 
					name="spouseaddressZip" 
					class="{{(myForm.spouseaddressZip.$touched) ? (myForm.spouseaddressZip.$valid ? 'valid' : 'error') : (conterror) ? (myForm.spouseaddressZip.$valid ? 'valid' : 'error') : ''}}" 
					placeholder="Zip Code" 
					maxlength="6"
					required>
			</div>
			<div class="my_in_frm_lt1">
				<br>
				<input type="text" 
					ng-model="data.spouseinfo.phone" 
					mask="(999) 999-9999" 
					restrict="reject" 
					ng-value="{{data.spouseinfo.phone}}" 
					class="{{(myForm.spousePhone.$touched) ? (myForm.spousePhone.$valid ? 'valid' : 'error') : (conterror) ? (myForm.spousePhone.$valid ? 'valid' : 'error') : ''}}" 
					name="spousePhone" 
					placeholder="Phone Number"
					clean="true" 
					required>
			</div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="spouseInfo3">
	<div class="row">
		<div class="BI_form1">
			<h2 class="BI_h1">Spouse’s Info</h2>
		</div>
		<div class="my_in_form">
			<div class="my_in_frm_lt1">
				<br>
				<input type="text" 
					ng-model="data.spouseinfo.job" 
					alphapet 
					class="{{(myForm.spouseJob.$touched) ? (myForm.spouseJob.$valid ? 'valid' : 'error') : (conterror) ? (myForm.spouseJob.$valid ? 'valid' : 'error') : ''}}" 
					name="spouseJob" 
					placeholder="Job Title" 
					maxlength="100" 
					required>
			</div>					
			<div class="my_in_frm_rt1">
				<br>
				<input type="text" 
					ng-model="data.spouseinfo.income" 
					class="{{(myForm.spouseIncome.$touched) ? (myForm.spouseIncome.$valid ? 'valid' : 'error') : (conterror) ? (myForm.spouseIncome.$valid ? 'valid' : 'error') : ''}}" 
					name="spouseIncome" 
					placeholder="Annual Income" 
					mask="$999,999,999"
					validate="false" 
					restrict="reject"
					clean="true"
					required>
			</div>
		</div>
	</div>
</script>

<script type="text/ng-template" id="ourProfile1">
	<div class="row">
		<div class="BI_form1">
			<h2 class="BI_h1">Our Profile</h2>
		</div>
		<div class="my_in_form">
			<div class="my_in_frm_lt_date"><span>Date Married:</span><br>
				<input 
					type="text" 
					ng-model="data.ourProfile.dom[0]" 
					mask="19" 
					ng-value="{{data.ourProfile.dom[0]}}" 
					restrict="reject" 
					class="mm_in {{(myForm.marriedMonth.$touched) ? (myForm.marriedMonth.$valid ? 'valid' : 'error') : (conterror) ? (myForm.marriedMonth.$valid ? 'valid' : 'error') : ''}}" 
					name="marriedMonth" 
					placeholder="MM" 
					maxlength="2" 
					required>
				<input 
					type="text" 
					ng-model="data.ourProfile.dom[1]" 
					mask="39" 
					ng-value="{{data.ourProfile.dom[1]}}" 
					restrict="reject" 
					class="mm_in1 {{(myForm.marriedDate.$touched) ? (myForm.marriedDate.$valid ? 'valid' : 'error') : (conterror) ? (myForm.marriedDate.$valid ? 'valid' : 'error') : ''}}" 
					name="marriedDate" 
					placeholder="DD" 
					maxlength="2" 
					required>
				<input 
					type="text" 
					name="marriedYear" 
					ng-model="data.ourProfile.dom[2]" 
					mask="9999" 
					ng-value="{{data.ourProfile.dom[2]}}" 
					class="mm_in2 {{(myForm.marriedYear.$touched) ? (myForm.marriedYear.$valid ? 'valid' : 'error') : (conterror) ? (myForm.marriedYear.$valid ? 'valid' : 'error') : ''}}" 
					restrict="reject" 
					placeholder="YYYY" 
					maxlength="4" 
					required>
			</div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="ourProfile2">
	<div class="row">
		<div class="BI_form1">
			<h2 class="BI_h1">Our Profile</h2>
			<p class="BI_p">Are you currently living together?</p>
		</div>
		<div class="margin_40"></div>
		<div ng-if="conterror" class="error">Please Select any option</div>
		<div class="form reg_form">		
			<md-radio-group ng-model="data.ourProfile.livingStatus" 
				class="{{(myForm.living_status.$touched) ? (myForm.living_status.$valid ? 'valid' : 'error') : (conterror) ? (myForm.living_status.$valid ? 'valid' : 'error') : ''}}" 
				name="living_status"
				required>
				<md-radio-button value="Y" class="md-primary yesBtn" >Yes</md-radio-button>
				<md-radio-button value="N" class="md-primary noBtn" >No</md-radio-button>
			</md-radio-group>
		</div>
	</div>
</script>
<script type="text/ng-template" id="ourProfile3">
	<div class="row">
		<div class="BI_form1">
			<h2 class="BI_h1">Our Profile</h2>
			<p class="BI_p">Do you and your spouse share any assets (home,cars,boars etc.)?</p>
		</div>
		<div class="margin_40"></div>
		<div ng-if="conterror" class="error">Please Select any option</div>
		<div class="form reg_form">	
			<md-radio-group ng-model="data.ourProfile.assets" 
				class="{{(myForm.assets.$touched) ? (myForm.assets.$valid ? 'valid' : 'error') : (conterror) ? (myForm.assets.$valid ? 'valid' : 'error') : ''}}" 
				name="assets"
				required>
				<md-radio-button value="Y" class="md-primary yesBtn" >Yes</md-radio-button>
				<md-radio-button value="N" class="md-primary noBtn" >No</md-radio-button>
			</md-radio-group>
		</div>
	</div>
</script>
<script type="text/ng-template" id="ourProfile4">
	<div class="row">
		<div class="BI_form1">
			<h2 class="BI_h1">Our Profile</h2>
			<p class="BI_p">Do you and your spouse share any debts (credit cards, mortgages, loans, etc.)?</p>
		</div>
		<div class="margin_40"></div>
		<div ng-if="conterror" class="error">Please Select any option</div>
		<div class="form reg_form">	
			<md-radio-group ng-model="data.ourProfile.debts" 
				class="{{(myForm.debts.$touched) ? (myForm.debts.$valid ? 'valid' : 'error') : (conterror) ? (myForm.debts.$valid ? 'valid' : 'error') : ''}}" 
				name="debts"
				required>
				<md-radio-button value="Y" class="md-primary yesBtn" >Yes</md-radio-button>
				<md-radio-button value="N" class="md-primary noBtn" >No</md-radio-button>
			</md-radio-group>
		</div>
	</div>
</script>
<script type="text/ng-template" id="ourProfile5"> 
	<div class="row">
		<div class="BI_form1">
			<h2 class="BI_h1">Our Profile</h2>
			<p class="BI_p">Will you or your spouse receive financial support from the other?</p>
		</div>				
		<div class="rd_sec1">
			<md-radio-group ng-model="data.ourProfile.finSupport"
				class="{{(myForm.ourFinsupport.$touched) ? (myForm.ourFinsupport.$valid ? 'valid' : 'error') : (conterror) ? 'error' : ''}}"
				name="ourFinsupport" 
				required>
				<div class="rd_lt0">
					<md-radio-button class="md-primary" value="I will receieve support">I will receieve support</md-radio-button>
				</div>
				<div class="rd_lt1">
					<md-radio-button class="md-primary" value="My spouse will receive support">My spouse will receive support</md-radio-button>
				</div>
				<div class="rd_lt2">
					<md-radio-button class="md-primary" value="Not sure / neither">Not sure / neither</md-radio-button>
				</div>
			</md-radio-group>
		</div>
	</div>
</script>
<script type="text/ng-template" id="basic_info_review">
	<div class="row basicreview">
		<div class="BI_form1">
			<h2 class="BI_h1">Reivew</h2>
		</div>
		<div class="my_reivew">
			<h2>My Info</h2>
			<hr>
			<div class="my_review_info">
				<div class="name_title">Why are you getting divorced? </div>
				<div class="name_title1">{{data.myInfo.why}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('0','0')">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Name</div>
				<div class="name_title1">{{data.myInfo.fname}} {{data.myInfo.lname}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('0','1')">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Date of Birth</div>
				<div class="name_title1">{{data.myInfo.dob[0]}}/{{data.myInfo.dob[1]}}/{{data.myInfo.dob[2]}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('0','1')">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Gender</div>
				<div class="name_title1">{{(data.myInfo.gender == 'M') ? 'Male' : 'Female' }}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('0','1')">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Address</div>
				<div class="name_title1">{{data.myInfo.street}}, {{data.myInfo.city}}, {{data.myInfo.state}}, {{data.myInfo.zipcode}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('0','2')">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Job title</div>
				<div class="name_title1">{{data.myInfo.job}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('0','3')">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Annual Income</div>
				<div class="name_title1">{{data.myInfo.income | currency:"$":0}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('0','3')">Edit</a></div>
			</div>					
		</div>

		<div class="my_reivew">
			<h2>Spouse’s Info</h2>
			<hr>
			<div class="my_review_info">
				<div class="name_title">Name</div>
				<div class="name_title1">{{data.spouseinfo.fname}} {{data.spouseinfo.fname}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('1','0')">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Date of Birth</div>
				<div class="name_title1">{{data.spouseinfo.dob[0]}}/{{data.spouseinfo.dob[1]}}/{{data.spouseinfo.dob[2]}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('1','0')">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Gender</div>
				<div class="name_title1">{{(data.spouseinfo.gender == 'M') ? 'Male' : 'Female'}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('1','0')">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Address</div>
				<div class="name_title1">{{data.spouseinfo.street}}, {{data.spouseinfo.city}}, {{data.spouseinfo.state}}, {{data.spouseinfo.zipcode}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('1','1')">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Job title</div>
				<div class="name_title1">{{data.spouseinfo.job}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('1','2')">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Annual Income</div>
				<div class="name_title1">{{data.spouseinfo.income | currency:"$":0}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('1','2')">Edit</a></div>
			</div>					
		</div>
		<div class="my_reivew">
			<h2>Our Profile</h2>
			<hr>
			<div class="my_review_info">
				<div class="name_title">Date Married</div>
				<div class="name_title1">{{data.ourProfile.dom[0]}}/{{data.ourProfile.dom[1]}}/{{data.ourProfile.dom[2]}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('2','0')">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Are you currently living together?</div>
				<div class="name_title1">{{(data.ourProfile.livingStatus == 'Y') ? 'Yes' : 'No'}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('2','1')">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Do you and your spouse share any assets (home,cars,boars etc.)?</div>
				<div class="name_title1">{{(data.ourProfile.assets == 'Y') ? 'Yes' : 'No'}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('2','2')">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Do you and your spouse share any debts (credit cards, mortgages, loans, etc.)?</div>
				<div class="name_title1">{{(data.ourProfile.debts == 'Y') ? 'Yes' : 'No'}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('2','3')">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Will you or your spouse receive financial support from the other?</div>
				<div class="name_title1">{{data.ourProfile.finSupport}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('2','4')">Edit</a></div>
			</div>					
		</div>
		<div class="reivew_btn125">
			<a href="#/form/kids">
				<button type="button">Continue</button>
			</a>	
		</div>
	</div>
</script>

<script type="text/ng-template" id="Custody1">
	<div class="row">
		<div class="sect_pad">
			<div class="content_sec_side">
				<h1 class="kids_h1">Tell us about your kids</h1>
				<p class="kids_p">I have<span class="child_no_se">
				<input type="text" 
					name="noofchild"
					ng-model="data.kidsRelation.noofchild"
					style="width: 50px" 
					>
				 </span>children under the age of 18...</p>
				<p class="kids_p">
				
					<md-checkbox 
						ng-model="data.kidsRelation.notborn" 
						
						value="Y">
						I have a child that isn’t born yet
					</md-checkbox>
				</p>
			</div>
			<div class="para_egg_sec">
				<img src="static/img/nl/3eggs_sec.png" alt="3eggs_sec">
				<p>This process is intended for couples who are able to come to a mutual agreement on custody for their kids. If you are having serious disputes with your spouse about your kid(s), including domestic violence and/or the threat of child abduction, you should speak with an attorney.</p>
			</div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="Custody2">
	<div class="row">
		<div class="sect_pad">
			<div class="more_abt_sec">
				<h1 class="kids_h1">More about your kids</h1>
				<p class="kids_p">Tell us about your kid(s)</p>
			</div>
			<div class="add_kid_form">
				<div id="contactTypeDiv">
	              <div class="row">
	              	<fieldset data-ng-repeat="kid in data.kids">
              			<div class="col-lg-12 kidsDetails">
              				<input 
              					type="text" 
              					name="kidfirstName{{$index}}" 
              					alphapet 
              					ng-model="kid.firstName" 
              					placeholder="First Name" 
              					class="fr_name {{(myForm['kidfirstName'+$index].$touched) ? (myForm['kidfirstName'+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidfirstName'+$index].$valid ? 'valid' : 'error') : ''}}"
              					required>
							<input class="mid_int" 
								type="text" 
								name="kidmiddleName" 
								alphapet 
								ng-model="kid.middleName" 
								placeholder="Middle Initial">
							<input 
								type="text" 
								name="kidlastName{{$index}}" 
								alphapet 
								ng-model="kid.lastName" 
								placeholder="Last Name"
								class="lst_name {{(myForm['kidlastName'+$index].$touched) ? (myForm['kidlastName'+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidlastName'+$index].$valid ? 'valid' : 'error') : ''}}" 
								required>
							<input  
								type="text" 
								name="kidbirthPlace{{$index}}" 
								ng-model="kid.birthPlace" 
								placeholder="City, State of Birth" 
								class="st_birth {{(myForm['kidbirthPlace'+$index].$touched) ? (myForm['kidbirthPlace'+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidbirthPlace'+$index].$valid ? 'valid' : 'error') : ''}}"
								alphapet-withcomma
								required>
							<div 
								class="dobKid" 
            					datepicker 
            					date-format="MM/dd/yyyy"
            					date-max-limit="{{today | date:'yyyy-MM-dd'}}" 
            					date-typer="false">
						        <input 
						        	ng-model="kid.dob" 
						        	type="text" 
						        	class="angular-datepicker-input" 
						        	placeholder="DOB mm/dd/yyyy" 
						        />
						    </div>
						</div>
						<div class="col-lg-12 text-right">
							<br>
							<md-radio-group ng-model="kid.gender" 
								ng-required="true"
								name="kidGender{{$index}}"
								class="{{(myForm['kidGender'+$index].$touched) ? (myForm['kidGender'+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidGender'+$index].$valid ? 'valid' : 'error') : ''}}"
								>
								<md-radio-button class="md-primary" value="M">
									Male
								</md-radio-button>
								<md-radio-button class="md-primary" value="F">
									Female
								</md-radio-button>
							</md-radio-group>
						</div>
	              	</fieldset>
					</div>
	            </div>
				<button type="button" class="add_kid_btn" ng-click="addKid()">Add a Kid</button>
			</div>				
				<div class="single_girl_sec">
					<img src="static/img/nl/single_girl.png" alt="single_girl">
					<p>The information we gather about your kid(s) is used to complete form FL105, the<br> “Declaration of under Uniform Child Custody Jurisdiction and Enforcement Act”.</p>
				</div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="Custody3">
	<div class="row">
		<div class="sect_pad">
			<div class="custody_valid_sec">
				<h1 class="kids_h1">Custody & Schedule</h1>
				<p>Next, you will propose custody of your kid(s) and create a schedule. Legal and physical custody determines who has decision making responsibility for the kid(s), in addition to who the kid(s) will spend their time with. This is a very important step, ideally discussed with your spouse.</p><br />
<p>However, keep in mind that you and your spouse will have the opportunity to modify custody and your schedule anytime after your divorce decree is granted. You will need to go back to the court to do so.</p>
			</div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="Custody4">
	<div class="row">
		<div class="sect_pad">
			<div class="custody_pater">
				<h1 class="kids_h1">Custody</h1>
				<p>Would you and your spouse like to share legal custody of your kid(s)?</p>
				<div class="margin_40"></div>
				<div class="form reg_form" name="form_2">	
					<md-radio-group ng-model="data.kidsRelation.legalCustody" 
						class="{{(myForm.kidsRelationleagalcus.$touched) ? (myForm.kidsRelationleagalcus.$valid ? 'valid' : 'error') : (conterror) ? (myForm.kidsRelationleagalcus.$valid ? 'valid' : 'error') : ''}}" 
						name="kidsRelationleagalcus"
						required>
						<md-radio-button value="Y" class="md-primary yesBtn" >Yes</md-radio-button>
						<md-radio-button value="N" class="md-primary noBtn" >No</md-radio-button>
					</md-radio-group>
				</div>
			</div>
			<div class="boy_img_sec">
				<img src="static/img/nl/boy_img.png" alt="boy_img">
				<p>Legal custody means being responsible for decision making regarding the health, safety and education of your kids.</p>
			</div>
		</div>
	</div>
</script>

<script type="text/ng-template" id="Custody5">
	<div class="row">
		<div class="sect_pad">
			<div class="add_kid_sect">
				<h1 class="kids_h1">Custody</h1>
				<p class="kids_p">If no, legal custody of the kid(s) under the age of 18 should go to</p>
			</div>
			<div class="col-md-12 add_kid_sect_tab_out">
				<v-accordion id="accordionKids" class="vAccordion--default" multiple control="accordionA" >
		           <v-pane id="{{ ::pane.id }}" ng-repeat="pane in data.kids" expanded='$first'>
		              <v-pane-header id="{{ ::pane.id }}-header" aria-controls="{{ ::pane.id }}-content" >
		                <h4 id="acc_title" data-width="" >
		                	<span class="per_are">{{ $index+1 }}</span>
							<div class="content">{{ ::pane.firstName }}</div>
		                </h4>
		              </v-pane-header>
		              <v-pane-content id="{{ ::pane.id }}-content" aria-labelledby="{{ ::pane.id }}-header">
	                	<div class="panel-body">
	                		<div class="row addkidsect_content">
                            	<div class="col-sm-3">
                            		<p><strong>Legal custody</strong><br> goes to (person who makes decisions about healthcare, education, etc.)</p>
                            	</div>
                            	<div class="col-sm-9">
                            		<p>
                            			<md-radio-group ng-model="pane.legalCustody"
                            				name="kidlegalcustody{{$index}}" 
                            				class="{{(myForm['kidlegalcustody'+$index].$touched) ? (myForm['kidlegalcustody'+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidlegalcustody'+$index].$valid ? 'valid' : 'error') : ''}}"
                            				required>
											<md-radio-button class="md-primary" value="Myself">
												Myself
											</md-radio-button>
											<md-radio-button class="md-primary" value="Spouse">
												Spouse
											</md-radio-button>
											<md-radio-button class="md-primary" value="Other">
												Other
											</md-radio-button>
										</md-radio-group>
	                            		<span>
	                            			<input ng-if="pane.legalCustody=='Other'" type="text" 
	                            				name="kidlegalcustodyother" 
	                            				ng-model="pane.legalCustodyOther" 
	                            				placeholder="Other (enter name)" 
	                            				class="{{(myForm['kidlegalcustodyother'+$index].$touched) ? (myForm['kidlegalcustodyother'+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidlegalcustodyother'+$index].$valid ? 'valid' : 'error') : ''}}"
	                            				required>
	                            		</span>
                            		</p>
                            	</div>			                            	
                            </div>
                        </div>
		              </v-pane-content>
		            </v-pane> 
	          	</v-accordion>
			</div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="Custody6">
	<div class="row">
		<div class="sect_pad">
			<div class="woud_spouse">
				<h1 class="kids_h1">Custody</h1>
				<p class="kids_p">Would you and your spouse like to share physical custody of your kid(s)?</p>
				<div class="margin_40"></div>
				<div class="form reg_form" name="form_2">
					<md-radio-group ng-model="data.kidsRelation.physicalCustody" 
						class="{{(myForm.kidrelationphysicalCustody.$touched) ? (myForm.kidrelationphysicalCustody.$valid ? 'valid' : 'error') : (conterror) ? (myForm.kidrelationphysicalCustody.$valid ? 'valid' : 'error') : ''}}" 
						name="kidrelationphysicalCustody"
						required>
						<md-radio-button value="Y" class="md-primary yesBtn" >Yes</md-radio-button>
						<md-radio-button value="N" class="md-primary noBtn" >No</md-radio-button>
					</md-radio-group>						
				</div>					
			</div>
			<div class="black_girl">
					<img src="static/img/nl/black_girl.png" alt="black_girl">
					<p>Physical custody means where the kid(s) spends the majority of their time.</p>					
			</div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="Custody7">
	<div class="row">
		<div class="sect_pad">
			<div class="add_kid_sect">
				<h1 class="kids_h1">Custody</h1>
				<p class="kids_p">If no, Physical custody of the kid(s) under the age of 18 should go to</p>
			</div>
			<div class="col-md-12 add_kid_sect_tab_out">
				<v-accordion id="accordionKids" class="vAccordion--default" multiple control="accordionA" >
		           <v-pane id="{{ ::pane.id }}" ng-repeat="pane in data.kids" expanded='$first'>
		              <v-pane-header id="{{ ::pane.id }}-header" aria-controls="{{ ::pane.id }}-content">
		                <h4 id="acc_title" data-width="" >
		                	<span class="per_are">{{ $index+1 }}</span>
							<div class="content">{{ ::pane.firstName }}</div>
		                </h4>
		              </v-pane-header>
		              <v-pane-content id="{{ ::pane.id }}-content" aria-labelledby="{{ ::pane.id }}-header">
	                	<div class="panel-body">
	                		<div class="row addkidsect_content">
                            	<div class="col-sm-4">
                            		<p><strong>Physical custody</strong> goes to the<br> person that the child/children spend<br> the majority of their time with.</p>
                            	</div>
                            	
                            	<div class="col-sm-8">
                            		<p>
                            			<md-radio-group ng-model="pane.physicalCustody"
                            				name="kidphysicalcustody{{$index}}" 
                            				class="{{(myForm['kidphysicalcustody'+$index].$touched) ? (myForm['kidphysicalcustody'+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidphysicalcustody'+$index].$valid ? 'valid' : 'error') : ''}}"
                            				ng-required="true"
                            				>
											<md-radio-button class="md-primary" value="Myself">
												Myself
											</md-radio-button>
											<md-radio-button class="md-primary" value="Spouse">
												Spouse
											</md-radio-button>
											<md-radio-button class="md-primary" value="Other">
												Other
											</md-radio-button>
										</md-radio-group>
										<span>
											<input ng-if="pane.physicalCustody=='Other'"
												type="text" 
												name="kidphysicalcustodyother{{$idex}}" 
												ng-model="pane.physicalCustodyOther" 
												placeholder="Other (enter name)" 
												class="{{(myForm['kidphysicalcustodyother'+$index].$touched) ? (myForm['kidphysicalcustodyother'+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidphysicalcustodyother'+$index].$valid ? 'valid' : 'error') : ''}}"
												required
												>
										</span>
                            		</p>
                            	</div>
                            </div>
                        </div>
		              </v-pane-content>
		            </v-pane> 
	          	</v-accordion>
			</div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="Custody8">
	<div class="row">
		<div class="sect_pad">
			<div class="add_kid_sect">
				<h1 class="kids_h1">Coparenting Schedule</h1>
				<p class="kids_p">Next, let’s talk about your kid(s) schedule.<br>Pick the option that works best for you and your spouse:</p>
			</div>	
			<div class="col-sm-12 cust_ptag">
				<p>
					<md-radio-group ng-model="data.kidsRelation.custodySchedule"
						name="kidsRelationcustodySchedule"
						class="{{(myForm['kidsRelationcustodySchedule'].$touched) ? (myForm['kidsRelationcustodySchedule'].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidsRelationcustodySchedule'].$valid ? 'valid' : 'error') : ''}}"
						ng-required="true">
						<md-radio-button class="md-primary" value="We will figure out a custody schedule on our own and come back to the court if needed">
							We will figure out a custody schedule on our own and come back to the court if needed
						</md-radio-button><br>
						<md-radio-button class="md-primary" value="We would like to see custody options">
							We would like to see custody options
						</md-radio-button><br>
						<md-radio-button class="md-primary" value="We would like to speak with a custody specialist">
							We would like to speak with a custody specialist
						</md-radio-button>
					</md-radio-group>
				</p>
			</div>					
		</div>
	</div>
</script>
<script type="text/ng-template" id="Shedule1">
	<div class="row">
		<div class="sect_pad">
			<div class="add_kid_sect">
				<h1 class="kids_h1">Create a Coparenting Schedule</h1>
				<p class="kids_p">"Laura A. Wasser explains solutions for creating a successful coparenting schedule."</p>
			</div>	
			<div class="youtube_vid_sec">
				<iframe height="402px" width="622px" scrolling="no"  frameborder="0" src="http://www.kidsinthehouse.com/video/embed/39481"></iframe>
				<p>For more information on <a href="http://www.kidsinthehouse.com/all-parents?ref=Partnership" title="Videos about parenting from Parenting Experts">parenting</a> visit <a href="http://www.kidsinthehouse.com/all-parents/divorce/co-parenting/custody-visitation-and-communication?ref=Partnership" title="Expert Parenting Advice">KidsInTheHouse.com</a></p>
			</div>					
		</div>
		<div ng-show="displayPop" class="popup2" id="test">
			<div class="popup-inner1">
				<div class="popup_sec1">
					<iframe src="http://www.courts.ca.gov/selfhelp-custody.htm" width="100%" height="700px" style="border: 0"></iframe>
				</div>
				<a class="popup-close" data-popup-close="popup-1" ng-click="popupClose3()">x</a>
			</div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="Shedule2">
	<div class="row">
			
		<div class="sect_pad">
			<div class="add_kid_sect">
				<h1 class="kids_h1">Schedule</h1>
				<p class="kids_p">Create a proposed co-parenting schedule for you and your spouse.</p>
				<p class="kids_p">Please note that this schedule can be modified any time, even after it is submitted with your divorce petition.</p>
			</div>	
			<div class="four_load_sec">
				<div class="col-sm-3">
					<div class="cusCount">
						<div class="circle">
							<span>{{noofdayeswithme}}</span>
						</div>
						<p class="content">Days with you</p>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="cusCount">
						<div class="circle">
							<span>{{noofdayeswithspouse}}</span>
						</div>
						<p class="content">Days with your spouse</p>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="cusCount">
						<div class="circle">
							<span>{{noofholidayswithme}}</span>
						</div>
						<p class="content">Holidays with you</p>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="cusCount">
						<div class="circle">
							<span>{{noofholidayswithspouse}}</span>
						</div>
						<p class="content">Holidays with your spouse</p>
					</div>
				</div>
			</div>	
			<div ng-init="loadGoogleApi()" class="calenderView">
				<div ng-if="loadingGoogleApi" class="calenderLoadingScreen">
					<div class="showbox">
					  <div class="loader">
					    <svg class="circular" viewBox="25 25 50 50">
					      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
					    </svg>
					  </div>
					</div>
				</div>
				<div class="cal_sec col-lg-12" ng-if="googleCalendar">
					<div class="calSideOption">
						<div class="calLeftTop">
							<h2 class="tempHead">
								Choose or Customize Schedule
							</h2>
							<div>
								<select class="tempSelect" ng-model="tempSelecter" ui-select2="{minimumResultsForSearch: -1}">
									<option value="">Select a Template</option>
									<option value="1">2-2-3</option>
									<option value="2">2-2-5</option>
									<option value="3">Custom</option>
								</select>
								<button class="tempChangeBtn blue" ng-click="updateEvent(tempSelecter)" >Apply Template</button>
								<button class="tempChangeBtn" ng-click="clearCal()">Clear</button>
							</div>
						</div>
						<div class="calLeftBottom">
							<h2 class="tempHead">
								Selected Holidays
							</h2>
							<div class="holidaySort">
								<span>Sort by:</span>
								<span>
									<label>
										<input type="checkbox" name="me" ng-model="holidaySortme">
										Me
									</label>
									<label>
										<input type="checkbox" name="spouse" ng-model="holidaySortspouse">
										Spouse
									</label>
								</span>
							</div>
							<div class="holidaysselected">
								<table>
									<tbody ng-if="holidaySortme">
										<tr ng-repeat="listitems in holidayList.religiousholidays.list" ng-if="listitems.odd == 'Petitioner' ? true : listitems.even == 'Petitioner' ? true : listitems.current == 'Petitioner' ? true : false ">
											<td width="150px">
												{{ listitems.text | strLimit: 12}} 	
											</td>
											<td>
												{{((listitems.odd == 'Petitioner' && listitems.even == 'Petitioner') || listitems.current == 'Petitioner' ) ? 'Both' : listitems.odd == 'Petitioner' ? 'Odd' : listitems.even == 'Petitioner' ? 'Even' : '' }} 
											</td>
										</tr>
										<tr ng-repeat="listitems in holidayList.standardholidays.list" ng-if="listitems.odd == 'Petitioner' ? true : listitems.even == 'Petitioner' ? true : listitems.current == 'Petitioner' ? true : false ">
											<td width="150px">
												{{ listitems.text | strLimit: 12}} 
											</td>
											<td>
												{{((listitems.odd == 'Petitioner' && listitems.even == 'Petitioner') || listitems.current == 'Petitioner') ? 'Both' : listitems.odd == 'Petitioner' ? 'Odd' : listitems.even == 'Petitioner' ? 'Even' : '' }}
											</td>
										</tr>
										<tr ng-repeat="listitems in holidayList.mybirthday.list" ng-if="listitems.odd == 'Petitioner' ? true : listitems.even == 'Petitioner' ? true : listitems.current == 'Petitioner' ? true : false ">
											<td width="150px">
												{{ listitems.text | strLimit: 12}} 
											</td>
											<td>
												{{((listitems.odd == 'Petitioner' && listitems.even == 'Petitioner') || listitems.current == 'Petitioner') ? 'Both' : listitems.odd == 'Petitioner' ? 'Odd' : listitems.even == 'Petitioner' ? 'Even' : '' }}
											</td>
										</tr>
									</tbody>
									<tbody ng-if="holidaySortspouse">
										<tr ng-repeat="listitems in holidayList.religiousholidays.list" ng-if="listitems.odd == 'Respondent' ? true : listitems.even == 'Respondent' ? true : listitems.current == 'Respondent' ? true : false ">
											<td width="150px">
												{{ listitems.text | strLimit: 12}} 	
											</td>
											<td>
												{{((listitems.odd == 'Respondent' && listitems.even == 'Respondent') || listitems.current == 'Respondent') ? 'Both' : listitems.odd == 'Respondent' ? 'Odd' : listitems.even == 'Respondent' ? 'Even' : '' }}
											</td>
										</tr>
										<tr ng-repeat="listitems in holidayList.standardholidays.list" ng-if="listitems.odd == 'Respondent' ? true : listitems.even == 'Respondent' ? true : listitems.current == 'Respondent' ? true : false ">
											<td width="150px">
												{{ listitems.text | strLimit: 12}} 
											</td>
											<td>
												{{((listitems.odd == 'Respondent' && listitems.even == 'Respondent') || listitems.current == 'Respondent') ? 'Both' : listitems.odd == 'Respondent' ? 'Odd' : listitems.even == 'Respondent' ? 'Even' : '' }}
											</td>
										</tr>
										<tr ng-repeat="listitems in holidayList.mybirthday.list" ng-if="listitems.odd == 'Respondent' ? true : listitems.even == 'Respondent' ? true : listitems.current == 'Respondent' ? true : false ">
											<td width="150px">
												{{ listitems.text | strLimit: 12}} 
											</td>
											<td>
												{{((listitems.odd == 'Respondent' && listitems.even == 'Respondent') || listitems.current == 'Respondent') ? 'Both' : listitems.odd == 'Respondent' ? 'Odd' : listitems.even == 'Respondent' ? 'Even' : '' }}
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div>
								<button class="tempChangeBtn green" ng-click="PopUpShow('holidayPop')" ng-init="initHolidayList()">{{alreadyAddred ? 'Add Holidays' : 'Add Holidays'}}</button>
							</div>
						</div>
					</div>
					<div class="calDisplay">
						<div ui-calendar="uiConfig.calendar" ng-model="calendarDate" calendar="myCalendar"></div> 					
					</div>
				</div>
				<div ng-if="!googleCalendar" class="cal_sec col-lg-12">
					<div class="googleAuthDiv">
						<a href="<?php echo base_url(); ?>api/googleApi/install" class="googleAuthBtn">Authenticate</a>
						<p>It’s Over Easy uses Google Calendar to create co-parenting schedules. This allows you to <br />
						apply our schedule templates, automatically calculate how many days your kids are spending<br />
						with you compared to your spouse, and easily share your calendar with your spouse.</p>
						<img src="static/img/nl/googleAuthIcon.png" alt="googleAuthIcon">
						<p><a href="https://accounts.google.com/SignUp?continue=https%3A%2F%2Faccounts.google.com%2Fo%2Foauth2%2Fauth%3Fresponse_type%3Dcode%26redirect_uri%3Dhttp%3A%2F%2Flocalhost%2FIOE%2Fapi%2FgoogleApi%2Fcallback%26client_id%3D147863786580-7p6eo3pdr0njcab86pmk72bvojsjpes1.apps.googleusercontent.com%26scope%3Dhttps%3A%2F%2Fwww.googleapis.com%2Fauth%2Fcalendar%2Bhttps%3A%2F%2Fwww.googleapis.com%2Fauth%2Fcalendar.readonly%26access_type%3Doffline%26approval_prompt%3Dforce%26from_login%3D1%26as%3Db8ab6a4bb7c4db">Click here</a> to create a google account if you do not have one.</p>
					</div>
				</div>				
			</div>
			<div ng-if="addHoliday" class="addHolidayPopup" id="editPopUpSec">
				<div class="editPopUpSecIn">
					<div class="editPopUpSecInIn">
						<div>
							<h1>Holidays</h1>
							<p>Create a proposed holiday schedule for you and your spouse. Click the empty boxes to designate who will take that holiday.  Leave holidays blank that do not pertain to you and they will not be added to the calendar. You can come back and modify this at any time.</p>
						</div>
						<v-accordion id="accordionA" class="vAccordion--default" control="accordionA">
							<v-pane id="{{ ::pane.id }}" ng-repeat="pane in holidayList" expanded="$first">
								<v-pane-header id="{{ ::pane.id }}-header" aria-controls="{{ ::pane.id }}-content">
									<h4 id="acc_title" data-width="" >
					                	<span class="per_are">{{ $index+1 }}</span>
										<div class="content">{{ ::pane.title}}</div>
					                </h4>
								</v-pane-header>
								<v-pane-content id="{{ ::pane.id }}-content" aria-labelledby="{{ ::pane.id }}-header">
									<div class="holidayContentSec">
										<table>
											<thead>
												<tr>
													<td>Holiday</td>
													<td>Date & Time</td>
													<td>Odd <br/>Years</td>
													<td>Even <br/>Years</td>
													<td style="text-align: center;">Every <br/>Year</td>
												</tr>
											</thead>
											<tbody>
												<tr ng-repeat="listVal in pane.list">
													<td>{{listVal.text}}</td>
													<td>
														<input type="text" name="" ng-model="listVal.date.start[0]">
														<input type="text" name="" ng-model="listVal.date.start[1]">
														<span>to</span>
														<input type="text" name="" ng-model="listVal.date.end[0]">
														<input type="text" name="" ng-model="listVal.date.end[1]">
													</td>
													<td>
														<select ui-select2 ng-model="one">
															<option value=""></option>
															<option value="Petitioner">Petitioner</option>
															<option value="Respondent">Respondent</option>
														</select>
													</td>
													<td>
														<select ui-select2 ng-model="two">
															<option value=""></option>
															<option value="Petitioner">Petitioner</option>
															<option value="Respondent">Respondent</option>
														</select>
													</td>
													<td>
														<select ui-select2 ng-model="three">
															<option value=""></option>
															<option value="Petitioner">Petitioner</option>
															<option value="Respondent">Respondent</option>
														</select>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</v-pane-content>
							</v-pane>
						</v-accordion>
					<a class="popup-close" data-popup-close="popup-1" ng-click="holidaysPopupClose()">x</a>
				</div>
			</div> 
		</div>
	</div>
</script>

<script type="text/ng-template" id="ChildSupport1">
	<div class="row">
		<div class="child_support1">					
			<h1 class="kids_h1">Child schedule - {{data.myInfo.fname}}</h1>
			<p class="kids_p">Each parent is equally responsible for providing for the financial needs of his<br> or her child. When your divorce petition is submitted, the court will make an<br> order establishing parentage (paternity) and make an order for child support.</p><br><br>
			<p class="kids_p">You and your spouse have the option of coming to your own agreement on<br> the monthly child support amount to be paid. Child support payments are<br> usually made until children turn 18 (or 19 if they are still in high school full<br> time, living at home, and cannot support themselves). </p><br><br>
			<p class="kids_p">If you and your spouse cannot come to a mutual agreement, the court will<br> order one party to pay support to the other.  The amount of support will be<br> calculated based on the California statewide formula (called a "guideline").</p>		

		<button type="button">Continue</button>
		</div>
		
	</div>
</script>
<script type="text/ng-template" id="ChildSupport2">
	<div class="row">
		<div class="sect_pad">
			<div class="child_support2">
				<h1 class="kids_h1">Child Support</h1>
				<p class="kids_p">What monthly child support amount would you like to propose?  This amount <br>will be paid by one spouse to the spouse with legal custody of the kid(s).</p>
			</div>
			<div class="ent_amt"><input type="text" name="" ng-model="data.kidsRelation.ChildSupportamount" placeholder="Enter amount $"></div>
			<div class="dollar_img">
					<img src="static/img/nl/dollar_img.png" alt="dollar_img">
					<p>This step is optional. If you and your spouse cannot reach an agreement on<br> the monthly child support to be paid, the court will mandate an amount <br>according to California guidelines.  <a ng-click="GuideLine()">Read the guidelines here ></a></p>					
			</div>
		</div>
		<div ng-show="displayPop" class="popup2" id="test">
			<div class="popup-inner1">
				<div class="popup_sec1">
					<iframe src="http://www.courts.ca.gov/selfhelp-custody.htm" width="100%" height="700px" style="border: 0"></iframe>
				</div>
				<a class="popup-close" data-popup-close="popup-1" ng-click="popupClose3()">x</a>
			</div>
		</div>
		<div class="popup1" data-popup="popup-1">
			<div class="popup-inner1">
				<div class="popup_sec1">
					<h1>Based on what you told us so far</h1>
					<div class="small_txt_sec">
						<p>You have <strong>{{data.noofchild}}</strong> kid(s)</p>
						<p>Your monthly net income is <strong>${{data.myInfo.income}}</strong>  and your tax filling status is Married/Single</p>
						<p>Your spouse’s monthly net income is <strong>${{data.spouseinfo.income}}</strong> and their tax filing status is Married/Single</p>
						<p>Legal custody if your kid(s) will be granted to Name and ## days will be spent per year with  Name</p>
						<p>##% will be spent with you (petitioner) and ##% will be spent per year with your spouse (respondent)</p>		
						<img src="static/img/nl/child_support.png" alt="child_support">	
					</div>
					<div class="big_txt_sec">
						
						<div class="row">
							<h1>
								<strong>We need a little more information to calculate estimated monthly<br>support according to California guidelines</strong>
							</h1>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<p>How much do you pay per month for health insurance?</p>
							</div>
							<div class="col-sm-12"><input type="text" placeholder="Enter amount $"></div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<p>How much does your spouse pay per month for health insurance? <br> <span>(you can estimate)</span> </p>
							</div>
							<div class="col-sm-12"><input type="text" placeholder="Enter amount $"></div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<p>How much child support do you pay for prior relationships?</p>
							</div>
							<div class="col-sm-12"><input type="text" placeholder="Enter amount $"></div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<p>How much child support does your spouse pay for prior relationships? <br><span>(you can estimate) </span></p>
							</div>
							<div class="col-sm-12"><input type="text" placeholder="Enter amount $"></div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<p>How much alimony do you pay for prior relationships?</p>
							</div>
							<div class="col-sm-12"><input type="text" placeholder="Enter amount $"></div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<p>How much alimony does your spouse pay for prior relationships? <br><span>(you can estimate)</span></p>
							</div>
							<div class="col-sm-12"><input type="text" placeholder="Enter amount $"></div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<p>How much was your morgage interest last year? <br><span>(you can estimate)</span></p>
							</div>
							<div class="col-sm-12"><input type="text" placeholder="Enter amount $"></div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<p>How much were your property taxes last year?	<br><span>(you can estimate)</span></p>
							</div>
							<div class="col-sm-12"><input type="text" placeholder="Enter amount $"></div>
						</div>
						
					</div>
					<div class="btn_pop_sec_lt"><button type="button">Calculate estimated monthly payments </button></div>
					<div class="btn_pop_sec_rt"><h1>$ Monthly payment amount</h1></div>
				</div>
				<a class="popup-close" data-popup-close="popup-1" ng-click="popupClose()">x</a>
			</div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="FinalDetails1">
	<div class="row">
		<div class="sect_pad">
			<div class="final_details1">
				<h1 class="kids_h1">Final Details</h1>
				<p class="kids_p">Have you and your kid(s) lived at the same address for the past 5 years?</p>
				<div class="margin_40"></div>
				<div class="form reg_form" name="form_2">			
					<md-radio-group ng-model="data.kidsRelation.kidslivingSameAddress" 
						class="{{(myForm.kidsRelationsameaddress.$touched) ? (myForm.kidsRelationsameaddress.$valid ? 'valid' : 'error') : (conterror) ? (myForm.kidsRelationsameaddress.$valid ? 'valid' : 'error') : ''}}" 
						name="kidsRelationsameaddress"
						required>
						<md-radio-button value="Y" class="md-primary yesBtn" >Yes</md-radio-button>
						<md-radio-button value="N" class="md-primary noBtn" >No</md-radio-button>
					</md-radio-group>
				</div>
			</div>	
		</div>	
	</div>
</script>
<script type="text/ng-template" id="FinalDetails2">
	<div class="row">
		<div class="sect_pad">
			<div class="final_details2">
				<h1 class="kids_h1">Final Details</h1>
				<p class="kids_p">If no, please list the addresses for the kid(s) during the past 5 years:</p>
			</div>

			<div class="col-md-12 add_kid_sect_tab_out1">
				<v-accordion id="accordionKids" class="vAccordion--default" multiple control="accordionA" >
		           <v-pane id="{{ ::pane.id }}" ng-repeat="pane in data.kids" expanded='$first'>
		              <v-pane-header id="{{ ::pane.id }}-header" aria-controls="{{ ::pane.id }}-content" expanded="true">
		                <h4 id="acc_title" data-width="" >
		                	<span class="per_are">{{ $index+1 }}</span>
							<div class="content">{{ ::pane.firstName }}</div>
		                </h4>
		              </v-pane-header>
		              <v-pane-content id="{{ ::pane.id }}-content" aria-labelledby="{{ ::pane.id }}-header">
	                	<div class="panel-body">
	                		<div class="row cur_add_sec" ng-repeat="paneaddress in pane.kidsaddress">
	                			<p>{{ $first ? 'Current Address' : 'Previous Address'}}</p>
                            	<div class="cur_add1">
                            		<input ng-if="$first" 
                            			type="text" 
                            			name="kidstreet{{$parent.$index;}}{{$index;}}" 
                            			ng-model="paneaddress.street"
                            			placeholder="Street" 
                            			class="{{(myForm['kidstreet'+$parent.$index+$index].$touched) ? (myForm['kidstreet'+$parent.$index+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidstreet'+$parent.$index+$index].$valid ? 'valid' : 'error') : ''}}" 
                            			maxlength="100"
                            			required>
                            		<input ng-if="!$first" type="text" 
                            			name="kidstreet{{$parent.$index}}{{$index}}" 
                            			ng-model="paneaddress.street" 
                            			placeholder="Street" >
                            	</div>
                            	<div class="cur_add2">
                            		<input ng-if="$first" type="text" 
                            			name="kidcity{{$parent.$index}}{{$index}}" 
                            			alphapet 
                            			ng-model="paneaddress.city" 
                            			placeholder="City" 
                            			class="{{(myForm['kidcity'+$parent.$index+$index].$touched) ? (myForm['kidcity'+$parent.$index+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidcity'+$parent.$index+$index].$valid ? 'valid' : 'error') : ''}}" 
                            			required>
                            		<input ng-if="!$first" type="text" 
                            			name="kidcity{{$parent.$index}}{{$index}}" 
                            			alphapet 
                            			ng-model="paneaddress.city" 
                            			placeholder="City" >
                            	</div>
                            	<div class="cur_add3">
                            		<input ng-if="$first" type="text" 
                            			name="kidstate{{$parent.$index}}{{$index}}" 
                            			alphapet 
                            			ng-model="paneaddress.state" 
                            			placeholder="State" 
                            			class="{{(myForm['kidstate'+$parent.$index+$index].$touched) ? (myForm['kidstate'+$parent.$index+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidstate'+$parent.$index+$index].$valid ? 'valid' : 'error') : ''}}" 
                            			required>
                            		<input ng-if="!$first" type="text" 
                            			name="kidstate{{$parent.$index}}{{$index}}" 
                            			alphapet 
                            			ng-model="paneaddress.state" 
                            			placeholder="State" >
                            	</div>
                            	<div class="cur_add4">
                            		<input ng-if="$first" type="text" 
                            			name="kidzip{{$parent.$index}}{{$index}}" 
                            			mask="99999" 
                            			restrict="reject" 
                            			ng-model="paneaddress.zip" 
                            			placeholder="Zip" 
                            			class="{{(myForm['kidzip'+$parent.$index+$index].$touched) ? (myForm['kidzip'+$parent.$index+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidzip'+$parent.$index+$index].$valid ? 'valid' : 'error') : ''}}" 
                            			required>
                            		<input ng-if="!$first" type="text" 
                            			name="kidzip{{$parent.$index}}{{$index}}" 
                            			mask="99999" 
                            			restrict="reject" 
                            			ng-model="paneaddress.zip" 
                            			placeholder="Zip">
                            	</div>
                            	<div class="person_kid">
                            	<p>Person kid lived with</p>
                            		<p ng-if="$first">
                            			<md-radio-group ng-model="paneaddress.livedWith"
                            				name="kidlivedWith{{$parent.$index}}{{$index}}" 
                            				class="{{(myForm['kidlivedWith'+$parent.$index+$index].$touched) ? (myForm['kidlivedWith'+$parent.$index+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidlivedWith'+$parent.$index+$index].$valid ? 'valid' : 'error') : ''}}"
                            				required>
											<md-radio-button class="md-primary" value="Myself">
												Myself
											</md-radio-button>
											<md-radio-button class="md-primary" value="Spouse">
												Spouse
											</md-radio-button>
											<md-radio-button class="md-primary" value="Other">
												Other
											</md-radio-button>
										</md-radio-group>
	                            		<span>
	                            			<input ng-if="paneaddress.livedWith == 'Other'" 
	                            				name="kidlivewithOther{{$parent.$index}}{{$index}}" 
	                            				class="{{(myForm['kidlivewithOther'+$parent.$index+$index].$touched) ? (myForm['kidlivewithOther'+$parent.$index+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidlivewithOther'+$parent.$index+$index].$valid ? 'valid' : 'error') : ''}}"
	                            				placeholder="Other" 
	                            				alphapet 
	                            				ng-model="paneaddress.livedWithOther" 
	                            				type="text" 
	                            				required>
	                            		</span>
                            		</p>
                            		<p ng-if="!$first">
                            			<md-radio-group ng-model="paneaddress.livedWith"
                            				name="kidlivedWith{{$parent.$index}}{{$index}}" >
											<md-radio-button class="md-primary" value="Myself">
												Myself
											</md-radio-button>
											<md-radio-button class="md-primary" value="Spouse">
												Spouse
											</md-radio-button>
											<md-radio-button class="md-primary" value="Other">
												Other
											</md-radio-button>
										</md-radio-group>
	                            		<span>
	                            			<input ng-if="paneaddress.livedWith == 'Other'" 
	                            				name="kidlivewithOther{{$parent.$index}}{{$index}}" 
	                            				placeholder="Other" 
	                            				alphapet 
	                            				ng-model="paneaddress.livedWithOther" 
	                            				type="text" >
	                            		</span>
                            		</p>
                            	</div>
                            	<div class="person_res">
                            		<p class="per_res">Period of residence</p>
                            		<div class="inputSec">
                            			<input ng-if="$first" name="kidrelationship{{$parent.$index}}{{$index}}" 
                            				ng-model="paneaddress.Relationship" 
                            				alphapet 
                            				placeholder="Relationship" 
                            				type="text" 
                            				class="{{(myForm['kidrelationship'+$parent.$index+$index].$touched) ? (myForm['kidrelationship'+$parent.$index+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidrelationship'+$parent.$index+$index].$valid ? 'valid' : 'error') : ''}}" 
                            				required>
                            			<input ng-if="!$first" 
                            				ng-model="paneaddress.Relationship" 
                            				alphapet 
                            				placeholder="Relationship" 
                            				ng-required="false"
                            				type="text" >
                            		</div>
                            		<div class="inputSec">
                            			<div class="fromdate">
                            				<div 
                            					datepicker 
                            					date-max-limit="{{today | date:'yyyy/MM/dd'}}" 
												date-format="MM/dd/yyyy"
												date-typer="true">
										        <input 
										        	ng-model="paneaddress.fromDate" 
										        	type="text" 
										        	class="angular-datepicker-input"
										        	placeholder="mm/dd/yyyy"
										        	/>
										    </div>	
                            			</div>
                            		</div>
                        			<div class="textTo">to</div>
                            		<div class="inputSec">
                            			<div class="todate">
                            				<div 
                            					datepicker 
                            					date-format="MM/dd/yyyy"
                            					date-typer="true">
										        <input 
										        	ng-model="paneaddress.toDate" 
										        	type="text" 
										        	class="angular-datepicker-input"
										        	placeholder="mm/dd/yyyy"/>
										    </div>	
                            			</div>
                            		</div>
                            		</span>			       
                            		</p>
                            	</div>
                            </div>
                            <div class="row cur_add_sec">
                            	<div class="add_pre_btn1"><button type="button" ng-click="kidsaddress(pane.kidsaddress)">Add previous address</button></div> 
                            </div>
                        </div>
		              </v-pane-content>
		            </v-pane> 
	          	</v-accordion>
			</div>				
		</div>
	</div>
</script>
<script type="text/ng-template" id="FinalDetails3">
	<div class="row">
		<div class="sect_pad">			
			<div class="final_details4">
				<h1 class="kids_h1">Final Details</h1>
				<p class="kids_p">Have you been involved in any other legal issues with your kid(s)?</p>
				<div class="margin_40"></div>
				<div class="form reg_form" name="form_2">	
					<md-radio-group ng-model="data.kidsRelation.kidsLegalissue" 
						class="{{(myForm.kidrelationkidsLegalissue.$touched) ? (myForm.kidrelationkidsLegalissue.$valid ? 'valid' : 'error') : (conterror) ? (myForm.kidrelationkidsLegalissue.$valid ? 'valid' : 'error') : ''}}" 
						name="kidrelationkidsLegalissue"
						required>
						<md-radio-button value="Y" class="md-primary yesBtn" >Yes</md-radio-button>
						<md-radio-button value="N" class="md-primary noBtn" >No</md-radio-button>
					</md-radio-group>					
						
				</div>
				<div class="hammer_img">
					<img src="static/img/nl/hammer_img.png" alt="hammer_img">
					<p>Legal issues could include adoption, juvenile court -<br> anything that required you to go to court for your kid(s).</p>
				</div>
			</div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="FinalDetails4">
	<div class="row">
		<div class="sect_pad">
			<div class="final_details5">
				<h1 class="kids_h1">Final Details</h1>
				<p class="kids_p">If yes, tell us about the legal issues</p>				
			</div>
			<div class="col-md-12 add_kid_sect_tab_out2">
				<v-accordion id="accordionKids" class="vAccordion--default" multiple control="accordionA" >
		           <v-pane id="{{ ::pane.id }}" ng-repeat="pane in data.kids" expanded='$first'>
		              <v-pane-header id="{{ ::pane.id }}-header" aria-controls="{{ ::pane.id }}-content" expanded=" {{ $first }} ">
		                <h4 id="acc_title" data-width="" >
		                	<span class="per_are">{{ $index+1 }}</span>
							<div class="content">{{ ::pane.firstName }}</div>
		                </h4>
		              </v-pane-header>
		              <v-pane-content id="{{ ::pane.id }}-content" aria-labelledby="{{ ::pane.id }}-header">
	                	<div class="panel-body">
	                		<div class="row " ng-repeat="panelegalissue in pane.kidslegalissue">
		                        <div class="row case_section">
			                        <div class="case_inn1"><span>Type</span></div>
			                        <div class="case_inn2"><span>Case Number</span></div>
			                        <div class="case_inn3"><span>Court</span></div>
			                        <div class="case_inn4"><span>Court Order or <br>Judgement date</span></div>
		                        	<div class="case_inn5"><span>Case status</span></div>
		                        </div>
	                            <div class="row case_section bot_area">
	                            	<div class="case_inn1 {{(myForm['kidlegalissueType'+$index].$touched) ? (myForm['kidlegalissueType'+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidlegalissueType'+$index].$valid ? 'valid' : 'error') : ''}}">
	                            		<select ui-select2
	                            			class="input_field" 
	                            			name="kidlegalissueType{{$index}}" 
	                            			ng-model="panelegalissue.type">
	                            			<option value="">Drop Down</option>
	                            			<option value="Family">Family</option>
	                            			<option value="Guardianship">Guardianship</option>
	                            			<option value="Juvenile Law">Juvenile Law</option>
	                            			<option value="Other">Other</option>
	                            		</select>
	                            	</div>
	                            	<div class="case_inn2">
	                            		<input type="text" 
	                            			name="kidleagalissuecasenumber{{$index}}" 
	                            			class="{{(myForm['kidleagalissuecasenumber'+$index].$touched) ? (myForm['kidleagalissuecasenumber'+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidleagalissuecasenumber'+$index].$valid ? 'valid' : 'error') : ''}}" 
	                            			ng-model="panelegalissue.caseNumber" 
	                            			placeholder="#####" 
	                            			>
	                            		</div>
	                            	<div class="case_inn3">
	                            		<input type="text" 
	                            			name="kidleagalissuecourt{{$index}}" 
	                            			class="{{(myForm['kidleagalissuecourt'+$index].$touched) ? (myForm['kidleagalissuecourt'+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidleagalissuecourt'+$index].$valid ? 'valid' : 'error') : ''}}"
	                            			ng-model="panelegalissue.court" 
	                            			placeholder="City, State" 
	                            			alphapet-withcomma
	                            			>
	                            	</div>
	                            	<div class="case_inn4">
	                            		<input type="text" 
	                            			name="kidleagalissuejudgementDate{{$index}}" 
	                            			class="{{(myForm['kidleagalissuejudgementDate'+$index].$touched) ? (myForm['kidleagalissuejudgementDate'+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidleagalissuejudgementDate'+$index].$valid ? 'valid' : 'error') : ''}}"
	                            			ng-model="panelegalissue.judgementDate" 
	                            			placeholder="mm/dd/yyyy" 
	                            			>
	                            	</div>
	                            	<div class="case_inn5 {{(myForm['kidlegalissueCaseStatus'+$index].$touched) ? (myForm['kidlegalissueCaseStatus'+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidlegalissueCaseStatus'+$index].$valid ? 'valid' : 'error') : ''}}">			                          	
	                            		<select ui-select2 
	                            			class="input_field" 
	                            			name="kidlegalissueCaseStatus{{$index}}"
	                            			ng-model="panelegalissue.caseStatus" >
	                            			<option value="">Drop Down</option>
	                            			<option value="Closed">Closed</option>
	                            			<option value="Open">Open</option>
	                            		</select>
	                            	</div>			                            	
	                            	<div class="case_inn6">
	                            			{{ item.isError }}
	                            		<label class="upload_btn">
	                            			<input type="file" 
	                            				nv-file-select="" 
	                            				uploader="uploader" 
	                            				multiple="" 
	                            				accept="doc|pdf">
	                            				Upload court documents<br>(optional)
	                            		</label>
		                        </div>
		                    </div>
                        </div>
                        <div class="row cur_add_sec">
                        	<div class="add_pre_btn1"><button type="button" ng-click="kidsprotective(pane.kidslegalissue)">Add Case</button></div> 
                        </div>
		              </v-pane-content>
		            </v-pane> 
	          	</v-accordion>
			</div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="FinalDetails5">
	<div class="row">
		<div class="final_details6">
			<h1 class="kids_h1">Final Details</h1>
			<p class="kids_p">Are there any protective or restraining orders in effect?</p>
			<div class="margin_40"></div>
			<div class="form reg_form" name="form_2">	
				<md-radio-group ng-model="data.kidsRelation.protective" 
					class="{{(myForm.kidsRelationprotective.$touched) ? (myForm.kidsRelationprotective.$valid ? 'valid' : 'error') : (conterror) ? (myForm.kidsRelationprotective.$valid ? 'valid' : 'error') : ''}}" 
					name="kidsRelationprotective"
					required>
					<md-radio-button value="Y" class="md-primary yesBtn" >Yes</md-radio-button>
					<md-radio-button value="N" class="md-primary noBtn" >No</md-radio-button>
				</md-radio-group>	
			</div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="FinalDetails6">
	<div class="row">
		<div class="final_details7">
			<h1 class="kids_h1">Final Details</h1>
			<p class="kids_p">If yes, tell us about the protective or restraining orders</p>					
		</div>
		<div class="col-md-12 add_kid_sect_tab_out3">
			<v-accordion id="accordionKids" class="vAccordion--default" multiple control="accordionA" >
	           <v-pane id="{{ ::pane.id }}" ng-repeat="pane in data.kids" expanded='$first'>
	              <v-pane-header id="{{ ::pane.id }}-header" aria-controls="{{ ::pane.id }}-content" expanded=" {{ $first }} ">
	                <h4 id="acc_title" data-width="" >
	                	<span class="per_are">{{ $index+1 }}</span>
						<div class="content">{{ ::pane.firstName }}</div>
	                </h4>
	              </v-pane-header>
	              <v-pane-content id="{{ ::pane.id }}-content" aria-labelledby="{{ ::pane.id }}-header">
                	<div class="panel-body">
                		<div class="row case_section protectiveRest" ng-repeat="paneprotective in pane.kidsprotective">
                        	<div class="case_inn1 ">Court<br>
                        		<select ui-select2 
                        			class="input_field" 
                        			ng-model="paneprotective.protectiveCourt" >
                        			<option value="">Drop Down</option>
                        			<option value="Criminal">Criminal</option>
                        			<option value="Family">Family</option>
                        			<option value="Juvenile Law">Juvenile Law</option>
                        			<option value="Other">Other</option>
                        		</select>
                        	</div>
                        	<div class="case_inn2">County<br>
                        		<input type="text" 
                        			ng-model="paneprotective.protectiveCountry" 
                        			placeholder="#####" 
                        			>
                        	</div>
                        	<div class="case_inn3">State<br>
                        		<input type="text" 
                        			ng-model="paneprotective.protectiveState" 
                        			placeholder="City, state" 
                        			alphapet-withcomma
                        			>
                        	</div>
                        	<div class="case_inn4">Case Number (if known)<br>
                        		<input type="text" 
                        			ng-model="paneprotective.protectiveCaseNumber" 
                        			placeholder="mm/dd/yyyy" 
                        			>
                        	</div>			                      	
                        	<div class="case_inn5">Orders expire (date)<br>
                        		<div 
                					datepicker 
                					date-max-limit="{{today | date:'yyyy/MM/dd'}}" 
									date-format="MM/dd/yyyy"
                					date-typer="true">
							        <input 
							        	ng-model="paneprotective.protectiveExpire" 
							        	type="text" 
							        	class="angular-datepicker-input"
							        	placeholder="mm/dd/yyyy"
							        	/>
							    </div>	
                        	</div>
	                    </div>
	                     <div class="row cur_add_sec">
                        	<div class="add_pre_btn1"><button type="button" ng-click="kidsprotective(pane.kidsprotective)">Add Case</button></div> 
                        </div>
                    </div>
	              </v-pane-content>
	            </v-pane> 
          	</v-accordion>
		</div>
	</div>
</script>
<script type="text/ng-template" id="FinalDetails7">
	<div class="row">
		<div class="final_details8">
			<h1 class="kids_h1">Final Details</h1>
			<p class="kids_p">Does any other person have legal claims for your kid(s)?</p>
			<div class="margin_40"></div>
			<div class="form reg_form" name="form_2">		
				<md-radio-group ng-model="data.kidsRelation.legalClaims" 
					class="{{(myForm.kidsRelationlegalClaims.$touched) ? (myForm.kidsRelationlegalClaims.$valid ? 'valid' : 'error') : (conterror) ? (myForm.kidsRelationlegalClaims.$valid ? 'valid' : 'error') : ''}}" 
					name="kidsRelationlegalClaims"
					required>
					<md-radio-button value="Y" class="md-primary yesBtn" >Yes</md-radio-button>
					<md-radio-button value="N" class="md-primary noBtn" >No</md-radio-button>
				</md-radio-group>
			</div>	
			<div class="beard_guys">
				<img src="static/img/nl/beard_guys.png" alt="beard_guys">
				<p>For example, a person with legal claims could have custody or visitation rights <br>for the kid(s), such as a biological parent, grandparents or other relatives.</p>	
			</div>				
		</div>	
	</div>
</script>
<script type="text/ng-template" id="FinalDetails8">
	<div class="row">
		<div class="final_details9">
			<h1 class="kids_h1">Final Details</h1>
			<p class="kids_p">Name and address of each person with legal claims, <br>who is not a part of this divorce proceeding</p>					
		</div>

		<div class="col-md-12 add_kid_sect_tab_out4">
			<v-accordion class="vAccordion--default" multiple>
				<v-pane id="{{ ::pane.id }}" ng-repeat="pane in data.kids" expanded='$first'>
	              <v-pane-header id="{{ ::pane.id }}-header" aria-controls="{{ ::pane.id }}-content" expanded=" {{ $first }} ">
	                <h4 id="acc_title" data-width="" >
	                	<span class="per_are">{{ $index+1 }}</span>
						<div class="content">{{ ::pane.firstName }}</div>
	                </h4>
	              </v-pane-header>
	              <v-pane-content id="{{ ::pane.id }}-content" aria-labelledby="{{ ::pane.id }}-header">
                	<div class="panel-body">
                		<div class="row has_section">
                        	<div class="has_inn1"><br>
                        		<input type="text" 
                        			name="kidlegalClaimspersonName{{$index}}" 
                        			class="{{(myForm['kidlegalClaimspersonName'+$index].$touched) ? (myForm['kidlegalClaimspersonName'+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['kidlegalClaimspersonName'+$index].$valid ? 'valid' : 'error') : ''}}"
                        			ng-model="pane.legalClaimspersonName" 
                        			placeholder="Name" 
                        			required>
                        	</div>
                        	<div class="has_inn2"><br>
                        		<input type="text" 
                        			name="legalClaimspersonAddress{{$index}}" 
                        			class="{{(myForm['legalClaimspersonAddress'+$index].$touched) ? (myForm['legalClaimspersonAddress'+$index].$valid ? 'valid' : 'error') : (conterror) ? (myForm['legalClaimspersonAddress'+$index].$valid ? 'valid' : 'error') : ''}}"
                        			ng-model="pane.legalClaimspersonAddress" 
                        			placeholder="Address" 
                        			required>
                        	</div>
                        	<div class="has_inn3">Has<br>physical custody<br>
                        		<md-checkbox ng-model="pane.legalClaimspersonHasphysicalcustody" aria-label="Checkbox 1"></md-checkbox>
                        	</div>
                        	<div class="has_inn4">Has<br>custody rights<br>
                        		<md-checkbox ng-model="pane.legalClaimspersonCustodyRights" aria-label="Checkbox 1"></md-checkbox>
                        	</div>
                        	<div class="has_inn5">Has<br>visitation rights<br>
                        		<md-checkbox ng-model="pane.legalClaimspersonVisitationRights" aria-label="Checkbox 1"></md-checkbox>
                        	</div>
                        </div>	
                    </div>
	              </v-pane-content>
	            </v-pane> 
			</v-accordion>
		</div>
	</div>
</script>
<script type="text/ng-template" id="kidsReview">
	<div class="row kidreview">
		<div class="BI_form1">
			<h2 class="BI_h1">Review</h2>
		</div>
		<div class="my_reivew">
			<div class="my_review_info">
				<div class="name_title">Number of Kids</div>
				<div class="name_title1">{{data.noofchild}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('0','0')">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Do you have a child that isn’t born yet?	</div>
				<div class="name_title1">{{ data.kidsRelation.notborn ? 'Yes' : 'No' }}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('0','0')">Edit</a></div>
			</div>	
			<hr>				
		</div>

		<div class="my_reivew" ng-repeat="kid in data.kids">
			<h2>Kid #{{$index+1}} - {{kid.firstName}} {{kid.middleName}} {{kid.lastName}}</h2>
			<hr>
			<div class="my_review_info">
				<div class="name_title">Full name</div>
				<div class="name_title1">{{kid.firstName}} {{kid.middleName}} {{kid.lastName}}</div>
				<div class="name_title2"><a href="" ng-click="reviewEdit('0','0')">Edit</a></div>
			</div>

			<div class="my_review_info">
				<div class="name_title">Sex</div>
				<div class="name_title1">{{kid.gender == 'M' ? 'Male' : 'Female'}}</div>
				<div class="name_title2"><a href="#">Edit</a></div>
			</div>

			<div class="my_review_info">
				<div class="name_title">City and State of birth</div>
				<div class="name_title1">{{kid.birthPlace}}</div>
				<div class="name_title2"><a href="#">Edit</a></div>
			</div>

			<div class="my_review_info">
				<div class="name_title">Birth date</div>
				<div class="name_title1">{{ kid.dob | date:'MM/dd/yyyy' }}</div>
				<div class="name_title2"><a href="#">Edit</a></div>
			</div>

			<div class="my_review_info">
				<div class="name_title">Would you and your spouse like to share legal custody</div>
				<div class="name_title1">{{data.kidsRelation.legalCustody == 'Y' ? 'Yes' : 'No'}}</div>
				<div class="name_title2"><a href="#">Edit</a></div>
			</div>

			<div ng-if="data.kidsRelation.legalCustody == 'N'" class="my_review_info">
				<div class="name_title">Who does legal custody go to?</div>
				<div class="name_title1">{{kid.legalCustody}}</div>
				<div class="name_title2"><a href="#">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Would you and your spouse like to share physical custody?</div>
				<div class="name_title1">{{data.kidsRelation.physicalCustody == 'Y' ? 'Yes' : 'No'}}</div>
				<div class="name_title2"><a href="#">Edit</a></div>
			</div>	

			<div ng-if="data.kidsRelation.physicalCustody == 'N'" class="my_review_info">
				<div class="name_title">Who does physical custody go to?</div>
				<div class="name_title1">{{kid.physicalCustody}}</div>
				<div class="name_title2"><a href="#">Edit</a></div>
			</div>
			<div class="my_review_info">
				<div class="name_title">How will you deal with physical custody?</div>
				<div class="name_title1">{{data.kidsRelation.custodySchedule}}</div>
				<div class="name_title2"><a href="#">Edit</a></div>
			</div>
			<div ng-if="data.kidsRelation.kidslivingSameAddress == 'N'" ng-repeat="kidaddress in kid.kidsaddress">
				<div class="my_review_info">
					<div class="name_title">{{ $first ? 'Current Address' : 'Previous Address'}}</div>
					<div class="name_title1">{{kidaddress.street}}, {{kidaddress.city}}, {{kidaddress.state}}, {{kidaddress.zip}}</div>
					<div class="name_title2"><a href="#">Edit</a></div>
				</div>
				<div class="my_review_info">
					<div class="name_title">Person lives with and Relationship</div>
					<div class="name_title1">{{kidaddress.livedWith}}, {{kidaddress.Relationship}}</div>
					<div class="name_title2"><a href="#">Edit</a></div>
				</div>
				<div class="my_review_info">
					<div class="name_title">Duration</div>
					<div class="name_title1">{{kidaddress.fromDate | date:'MM/dd/yyyy' }} - {{kidaddress.toDate | date:'MM/dd/yyyy'}}</div>
					<div class="name_title2"><a href="#">Edit</a></div>
				</div>	
			</div>
			<div class="my_review_info">
				<div class="name_title">Have you been involved in any legal issues with your kid(s)?</div>
				<div class="name_title1">{{data.kidsRelation.kidsLegalissue == 'Y' ? 'Yes' : 'No'}}</div>
				<div class="name_title2"><a href="#">Edit</a></div>
			</div>
			<div ng-if="data.kidsRelation.kidsLegalissue != 'Y'">
				<div ng-repeat="kidslegalissues in kid.kidslegalissue">
					<div class="my_review_info">
						<div class="name_title">Type</div>
						<div class="name_title1">{{kidslegalissues.type}}</div>
						<div class="name_title2"><a href="#">Edit</a></div>
					</div>
					<div class="my_review_info">
						<div class="name_title">Case Number</div>
						<div class="name_title1">{{kidslegalissues.caseNumber}}</div>
						<div class="name_title2"><a href="#">Edit</a></div>
					</div>
					<div class="my_review_info">
						<div class="name_title">Court</div>
						<div class="name_title1">{{kidslegalissues.court}}</div>
						<div class="name_title2"><a href="#">Edit</a></div>
					</div>
					<div class="my_review_info">
						<div class="name_title">Court Order or Judgment date</div>
						<div class="name_title1">{{kidslegalissues.judgementDate | date:'MM/dd/yyyy'}}</div>
						<div class="name_title2"><a href="#">Edit</a></div>
					</div>
				</div>
			</div>
			
			<div class="my_review_info">
				<div class="name_title">Are there any protective or restraining orders in effect?</div>
				<div class="name_title1">{{data.kidsRelation.protective == 'Y' ? 'Yes' : 'No'}}</div>
				<div class="name_title2"><a href="#">Edit</a></div>
			</div>
			<div ng-if="data.kidsRelation.protective != 'N'">
				<div ng-repeat="kidprotective in kid.kidsprotective">
					<div class="my_review_info">
						<div class="name_title">Court</div>
						<div class="name_title1">{{kidprotective.protectiveCourt}}</div>
						<div class="name_title2"><a href="#">Edit</a></div>
					</div>
					<div class="my_review_info">
						<div class="name_title">County</div>
						<div class="name_title1">{{kidprotective.protectiveCountry}}</div>
						<div class="name_title2"><a href="#">Edit</a></div>
					</div>
					<div class="my_review_info">
						<div class="name_title">State</div>
						<div class="name_title1">{{kidprotective.protectiveState}}</div>
						<div class="name_title2"><a href="#">Edit</a></div>
					</div>
					<div class="my_review_info">
						<div class="name_title">Case Number</div>
						<div class="name_title1">{{kidprotective.protectiveCaseNumber}}</div>
						<div class="name_title2"><a href="#">Edit</a></div>
					</div>
					<div class="my_review_info">
						<div class="name_title">Order expires</div>
						<div class="name_title1">{{kidprotective.protectiveExpire | date:'MM/dd/yyyy' }}</div>
						<div class="name_title2"><a href="#">Edit</a></div>
					</div>
				</div>
			</div>
			<div class="my_review_info">
				<div class="name_title">Does any other person have legal claims for your kid(s)?</div>
				<div class="name_title1">{{data.kidsRelation.legalClaims == 'Y' ? 'Yes' : 'No'}}</div>
				<div class="name_title2"><a href="#">Edit</a></div>
			</div>
			<div ng-if="data.kidsRelation.legalClaims != 'N'">
				<div class="my_review_info">
					<div class="name_title">Name</div>
					<div class="name_title1">{{kid.legalClaimspersonName}}, {{kid.legalClaimspersonAddress}}</div>
					<div class="name_title2"><a href="#">Edit</a></div>
				</div>
				<div class="my_review_info">
					<div class="name_title">Claims Physical</div>
					<div class="name_title1">{{kid.legalClaimspersonHasphysicalcustody ? 'Physical Custody' : ''}} {{kid.legalClaimspersonCustodyRights ? 'Custody Rights' : ''}} {{kid.legalClaimspersonVisitationRights ? 'Visitation Rights' : ''}}</div>
					<div class="name_title2"><a href="#">Edit</a></div>
				</div>
			</div>
			

		</div>
		<div class="review_fin_hd">
			<h1><a href=""> Modify your custody schedule</a></h1>
		</div>
		<div class="reivew_btn125">
			<a href="#/HaveOwe">
				<button type="button">Continue</button>				
			</a>
		</div>
	</div>
</script>
<script type="text/ng-template" id="uploadpop">
	<div class="row">
		<div class="col-md-9" style="margin-bottom: 40px">
            <h3>Upload queue</h3>
            <p>Queue length: {{ uploader.queue.length }}</p>
            <table class="table">
                <thead>
                    <tr>
                        <th width="50%">Name</th>
                        <th ng-show="uploader.isHTML5">Size</th>
                        <th ng-show="uploader.isHTML5">Progress</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in uploader.queue">
                        <td><strong>{{ item.file.name }}</strong></td>
                        <td ng-show="uploader.isHTML5" nowrap>{{ item.file.size/1024/1024|number:2 }} MB</td>
                        <td ng-show="uploader.isHTML5">
                            <div class="progress" style="margin-bottom: 0;">
                                <div class="progress-bar" role="progressbar" ng-style="{ 'width': item.progress + '%' }"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span ng-show="item.isSuccess"><i class="glyphicon glyphicon-ok"></i></span>
                            <span ng-show="item.isCancel"><i class="glyphicon glyphicon-ban-circle"></i></span>
                            <span ng-show="item.isError"><i class="glyphicon glyphicon-remove"></i></span>
                        </td>
                        <td nowrap>
                            <button type="button" class="btn btn-success btn-xs" ng-click="item.upload()" ng-disabled="item.isReady || item.isUploading || item.isSuccess">
                                <span class="glyphicon glyphicon-upload"></span> Upload
                            </button>
                            <button type="button" class="btn btn-warning btn-xs" ng-click="item.cancel()" ng-disabled="!item.isUploading">
                                <span class="glyphicon glyphicon-ban-circle"></span> Cancel
                            </button>
                            <button type="button" class="btn btn-danger btn-xs" ng-click="item.remove()">
                                <span class="glyphicon glyphicon-trash"></span> Remove
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
	</div>
</script>
<div class="popevent">
	<div ng-include src="showPop"></div>
</div>
<script type="text/ng-template" id="popupForm">
	<div>
        <div class="close" ng-click="closeEventPop()">x</div>
        <form name="addEvForm">
            <h1>Event</h1>
            <select ng-model="addEV.title" name="title" class="{{ (EvError && addEvForm.title.$invalid) ? 'error' : '' }}" required>
            	<option value=""></option>
            	<option value="Petitioner (You)">Petitioner (You)</option>
            	<option value="Respondent (Spouse)">Respondent (Spouse)</option>
            </select>
            <h1>when</h1>
            <div>
            	<div class="evDatePic" 
					datepicker 
					date-format="MM/dd/yyyy"
					date-typer="false">
			        <input 
			        	ng-model="addEV.start" 
			        	type="text" 
			        	class="angular-datepicker-input"
			        	placeholder="MM/DD/YYYY"
			        	name="start"
			        	required 
			        	/>
			    </div>
			    <div class="evDatePic" 
					datepicker 
					date-format="MM/dd/yyyy"
					date-typer="false">
			        <input 
			        	ng-model="addEV.end" 
			        	type="text" 
			        	class="angular-datepicker-input"
			        	placeholder="MM/DD/YYYY"
			        	name="end" 
			        	required 
			        	/>
			    </div>
            </div>
            
            <h1>Calendar</h1>
            <span>Kids Schedule</span>
            <button ng-if="addEvForm.$invalid" class="primaryBtn" ng-click="EvError = true;">Submit</button>
            <button ng-if="addEvForm.$valid" class="primaryBtn" ng-disabled="addEvForm.$invalid" ng-click="addEvent(addEV)">Submit</button>
        </form>
    </div>
</script>
<script type="text/ng-template" id="popupEventForm">
	<div>
        <div class="close" ng-click="closeEventPop()">x</div>
        <form name="editEvForm">
            <h1 ng-if="!eventUpdateFlag" class="neb-title">{{eventTitle}}</h1>
            <h1 ng-if="eventUpdateFlag">Event</h1>
            <select ng-if="eventUpdateFlag" ng-model="editEV.title" name="title" required>
            	<option value=""></option>
            	<option value="Petitioner (You)" >Petitioner (You)</option>
            	<option value="Respondent (Spouse)" >Respondent (Spouse)</option>
            </select>
            
            <h1>when</h1>
            <span ng-if="!eventUpdateFlag">{{startDate | date : 'MM/dd/yyyy'}} - {{endDate | date : 'MM/dd/yyyy'}}</span>
            <div ng-if="eventUpdateFlag">
            	<div class="evDatePic" 
					datepicker 
					date-format="MM/dd/yyyy"
					date-typer="false">
			        <input 
			        	ng-model="editEV.start | date : 'MM/dd/yyyy'" 
			        	type="text" 
			        	class="angular-datepicker-input"
			        	placeholder="MM/DD/YYYY"
			        	/>
			    </div>
			    <div class="evDatePic" 
					datepicker 
					date-format="MM/dd/yyyy"
					date-typer="false">
			        <input 
			        	ng-model="editEV.end | date : 'MM/dd/yyyy'" 
			        	type="text" 
			        	class="angular-datepicker-input"
			        	placeholder="MM/DD/YYYY"
			        	/>
			    </div>
            </div>
            <h1>Calendar</h1>
            <span>Kids Schedule</span>
            <button ng-if="!eventUpdateFlag" class="primaryBtn" ng-click="editEventPopUp()">Edit</button>
            <button ng-if="eventUpdateFlag" class="primaryBtn" ng-disabled="editEvForm.$invalid" ng-click="updateEventSingle(editEV)">Update</button>
            <button class="deleteBtn" ng-click="deleteEvent(eventId)">Delete</button>
        </form>
    </div>
</script>