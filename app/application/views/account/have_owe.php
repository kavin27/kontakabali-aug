<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="mainLoading" ng-if="isloading">
	<p>Loading...</p>
</div>
<div class="overlayEnablehaveowe" ng-if="overlayEnable && !isloading">
	<p>
		<img src="static/img/icons/overlay/haveOwe/1.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/haveOwe/2.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/haveOwe/3.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/haveOwe/4.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/haveOwe/5.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/haveOwe/6.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/haveOwe/7.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/haveOwe/8.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/haveOwe/9.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/haveOwe/10.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/haveOwe/11.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/haveOwe/12.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/haveOwe/13.png">
	</p>
	<p>
		<img src="static/img/icons/overlay/haveOwe/14.png">
	</p>
	
	<div class="closeA" ng-click="closeOverlay()">
		<img src="static/img/icons/overlay/close.png">
	</div>
</div>

<header ng-if="!ShowReview" class="haveOweHead">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-4 offset-0">
				<nav>
					<ul class="nav navbar-nav" >
						<li class="dropdown">
							<a class="btn btn-default addNew" ng-click="addNewToggle('assets')">
								+ Add New Asset
							</a>
							<div ng-if="assetsnewshow" class="addNewAssetsForm addNewAssetsFormSec">
								<div ng-include src="'addNewAssetsForm'"></div>
							</div>
							<div ng-if="assetsnewshow" class="overlayaddnew" ng-click="addNewClose('assets')">
								
							</div>

						</li>
						<li class="dropdown">
							<a class="btn btn-default dropdown-toggle addNew" ng-click="addNewToggle('debt')">+ Add New Debt</a>
							<div ng-if="debtnewshow" class="addNewAssetsForm addNewDebtFormSec">
								<div ng-include src="'addNewDebtForm'"></div>
							</div>
							<div ng-if="debtnewshow" class="overlayaddnew overlaydebt" ng-click="addNewClose('debt')">
								
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
							<a class="btn btn-default addNew" data-toggle="dropdown">Export </a>
							<ul class="dropdown-menu">
								<li>
									<a href="api/auth/csv">CSV</a>
								</li>
								<li>
									<a href="api/auth/pdf">PDF</a>
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

<section ng-if="!ShowReview" ng-init="loadHaveOwe()">
	<div class="assetsHead">
		<div ng-repeat="(key, value) in total.assetsTotal" class="col-md-4">
			<span ng-if="key != 'shared'" class="totlaAmount {{key=='me' ? 'left' : key=='spouse' ? 'right' : 'left'}}">
				{{value | currency:"$":0}}
			</span>
			<span ng-if="key == 'shared'" class="totlaAmount left">{{value/2 | currency:"$":1}}</span>
			<span ng-if="key == 'shared'" class="totlaAmount right">{{value/2 | currency:"$":1}}</span>
		</div>
		
	</div>
	<div class="assetsBody">
		<div ng-repeat="(listName, list) in models.listsAssets" class="col-md-4">
			<p ng-if="$first" class="typeHead">Assets</p>
			<h1>{{listName == 'spouse' ? 'My Spouse' : listName}}</h1>
		    <ul dnd-list="list" 
		    	class="assetList"
		    	ng-scrollbars
		    	ng-scrollbars-config="{theme:'dark-3', alwaysShowScrollbar:0, scrollButtons:{enable:false}}"
		    	dnd-drop="dropCallback(event, index, item, external, type)"
		    >
		        <li ng-repeat="item in list"
		            dnd-draggable="item"
		            dnd-moved="list.splice($index, 1)"
		            dnd-effect-allowed="move"
		            dnd-selected="models.selected = item"
		            ng-class="{'selected': models.selected === item}"
		            dnd-dragend="logEvent('assets', event)"
		            >
		            <div class="hoverOption">
		            	<ul>
		            		<li>
		            			<a href="" ng-click="dalete('assets',item.id)">Delete</a>
		            		</li>
		            		<li>
		            			<a href="" ng-click="edit(item.id, 'assets')">Edit</a>
		            		</li>
		            	</ul>
		            	<div class="textMsg">
		            		&lt; Drag and Drop &gt;
		            	</div>
		            </div>
		            <div class="assetIcon">
	            		<img src="static/img/icons/have_owe/assets/{{item.assetName}}.png">
		            </div>
		            <div class="assetText">
		            	<span class="leftVal" ng-if="listName == 'shared'">{{item.assetsEstimation/2 | currency:"$":1}}</span>
		            	<span class="rightVal" ng-if="listName == 'shared'">{{item.assetsEstimation/2 | currency:"$":1}}</span>
	            		<span class="rightVal" ng-if="listName != 'shared'">{{item.assetsEstimation | currency:"$":0}}</span>
	            		<span class="{{ listName == 'shared' ? 'titleHO' : 'titleHO'}}">{{assetsTypeList[item.assetName]}}</span>
	            		<span class="typeName">{{item.assetTypeName}}</span>
		            </div>
		        </li>
		    </ul>
		</div>
	</div>
	<div class="debtsHead">
		<div ng-repeat="(key, value) in total.debtTotal" class="col-md-4">
			<span ng-if="key != 'shared'" class="totlaAmount {{key=='me' ? 'left' : key=='spouse' ? 'right' : 'left'}}">
				-{{value | currency:"$":0}}
			</span>
			<span ng-if="key == 'shared'" class="totlaAmount left">-{{value.me | currency:"$":0}}</span>
			<span ng-if="key == 'shared'" class="totlaAmount right">-{{value.spouse | currency:"$":0}}</span> 
		</div>
	</div>
	<div class="debtsBody">
		<div ng-repeat="(listName, list) in models.listDebt" class="col-md-4">
			<p ng-if="$first" class="typeHead">Debts</p>
		    <ul dnd-list="list" 
		    	class="debtList"
		    	ng-scrollbars
		    	ng-scrollbars-config="{theme:'dark-3', alwaysShowScrollbar:0, scrollButtons:{enable:false}}"
		    	dnd-drop="dropCallbackDebt(event, index, item, external, type)"
		    >
		        <li ng-repeat="item in list"
		            dnd-draggable="item"
		            dnd-moved="list.splice($index, 1)"
		            dnd-effect-allowed="move"
		            dnd-selected="models.selected = item"
		            ng-class="{'selected': models.selected === item}"
		            dnd-dragend="logEventDebt('debt', event)"
		            >
		            <div class="hoverOption">
		            	<ul>
		            		<li>
		            			<a href="" ng-click="dalete('debt',item.id)">Delete</a>
		            		</li>
		            		<li>
		            			<a href="" ng-click="edit(item.id, 'debt')">Edit</a>
		            		</li>
		            	</ul>
		            	<div class="textMsg">
		            		&lt; Drag and Drop &gt;
		            	</div>
		            </div>
		            <div class="assetIcon">
	            		<img src="static/img/icons/have_owe/debts/{{item.debtType}}.png">
		            </div>
		            <div class="assetText">
		            	<span class="leftVal" ng-if="listName == 'shared'">{{item.howMuchDebtGot | currency:"$":1}}</span>
		            	<span class="rightVal" ng-if="listName == 'shared'">{{item.howMuchDebtGotSpouse | currency:"$":1}}</span>
	            		<span ng-if="listName == 'spouse'">{{item.howMuchDebtGotSpouse | currency:"$":0}}</span>
	            		<span ng-if="listName == 'me'">{{item.howMuchDebtGot | currency:"$":0}}</span>
	            		<span class="{{ listName == 'shared' ? 'titleHO' : ''}}">{{debtTypeList[item.debtType]}}</span>
	            		<span class="typeName">{{item.debtTypeName}}</span>
		            </div>
		        </li>
		    </ul>
		</div>
	</div>
	<div class="haveFooter">
		<div class="col-lg-4">
			<div class="finalAmount left">{{(total.assetsTotal.me - total.debtTotal.me) | currency:"$":0}}</div>
		</div>
		<div class="col-lg-4">
			<div class="finalAmount">
				{{((total.assetsTotal.shared/2)-total.debtTotal.shared.me) + ((total.assetsTotal.shared/2)-total.debtTotal.shared.spouse) | currency:"$":0}}
			</div>
		</div>
		<div class="col-lg-4">
			<div class="finalAmount right">{{(total.assetsTotal.spouse - total.debtTotal.spouse) | currency:"$":0}}</div>
		</div>
	</div>
</section>
<div ng-if="openPopUp" class="overlay">
	<div class="PopUp">
		<div ng-click="PopUpHide()" class="PopUpClose">X</div>
		<div ng-include src="PopUpTemp"></div>
	</div>
</div>
<div ng-if="ShowReview" class="haveOweReview">
	<div class="container">
		<!-- <div class="row">
			<div class="col-lg-12">
				<div class="formNav">
					<a href="" ng-click="gobackHaveOwe()" class="previous">Previous</a>		
					<a href="#/MakeSpend" class="next">
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
			<a href="" ng-click="gobackHaveOwe()" class="previous">Previous</a>
			<h1 class="reviewHead">Review</h1>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<h1 class="reviewInnerHead">Me</h1>
			</div>
			<div ng-if="models.listsAssets.me.length" class="col-lg-12">
				<h2 class="reviewInnerTypeHead">Assets</h2>
				<ul>
					<li ng-repeat="items in models.listsAssets.me">
						<div>
							<div class="icon">
								<img src="static/img/icons/have_owe/assets/{{items.assetName}}.png" alt="icon" width="31" height="31">
							</div>
							<span>{{assetsTypeList[items.assetName]}}</span>
							<span>{{items.assetsEstimation | currency:"$":0}}</span>
						</div>
						<div>
							<a ng-click="edit(items.id, 'assets')">Edit</a>
						</div>
					</li>
				</ul>
			</div>
			<div ng-if="models.listDebt.me.length" class="col-lg-12">
				<h2 class="reviewInnerTypeHead">Debts</h2>
				<ul>
					<li ng-repeat="items in models.listDebt.me">
						<div>
							<div class="icon">
								<img src="static/img/icons/have_owe/debts/{{items.debtType}}.png" alt="icon" width="31" height="31">
							</div>
							<span>{{debtTypeList[items.debtType]}}</span>
							<span class="red">-{{items.howMuchDebtGot | currency:"$":0}}</span>
						</div>
						<div>
							<a ng-click="edit(items.id, 'debt')">Edit</a>
						</div>
					</li>
				</ul>
			</div>
			<div class="col-lg-12">
				<div class="total_sec">
					<div class="backtoDash">
						<a href="" ng-click="gobackHaveOwe()">+ Add Assets and Debts</a>
					</div>
					<div class="total_val">
						Total: {{(total.assetsTotal.me - total.debtTotal.me) | currency:"$":0}}
					</div> 
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<h1 class="reviewInnerHead">Spouse</h1>
			</div>
			<div ng-if="models.listsAssets.spouse.length" class="col-lg-12">
				<h2 class="reviewInnerTypeHead">Assets</h2>
				<ul>
					<li ng-repeat="items in models.listsAssets.spouse">
						<div>
							<div class="icon">
								<img src="static/img/icons/have_owe/assets/{{items.assetName}}.png" alt="icon" width="31" height="31">
							</div>
							<span>{{assetsTypeList[items.assetName]}}</span>
							<span>{{items.assetsEstimation | currency:"$":0}}</span>
						</div>
						<div>
							<a ng-click="edit(items.id, 'assets')">Edit</a>
						</div>
					</li>
				</ul>
			</div>
			<div ng-if="models.listDebt.spouse.length" class="col-lg-12">
				<h2 class="reviewInnerTypeHead">Debts</h2>
				<ul>
					<li ng-repeat="items in models.listDebt.spouse">
						<div>
							<div class="icon">
								<img src="static/img/icons/have_owe/debts/{{items.debtType}}.png" alt="icon" width="31" height="31">
							</div>
							<span>{{debtTypeList[items.debtType]}}</span>
							<span class="red">-{{items.howMuchDebtGotSpouse | currency:"$":0}}</span>
						</div>
						<div>
							<a ng-click="edit(items.id, 'debt')">Edit</a>
						</div>
					</li>
				</ul>
			</div>
			<div class="col-lg-12">
				<div class="total_sec">
					<div class="backtoDash">
						<a href="" ng-click="gobackHaveOwe()">+ Add Assets and Debts</a>
					</div>
					<div class="total_val">
						Total: {{(total.assetsTotal.spouse - total.debtTotal.spouse) | currency:"$":0}}
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<h1 class="reviewInnerHead">Shared</h1>
			</div>
			<div ng-if="models.listsAssets.shared.length" class="col-lg-12">
				<h2 class="reviewInnerTypeHead">Assets</h2>
				<ul>
					<li ng-repeat="items in models.listsAssets.shared">
						<div>
							<div class="icon">
								<img src="static/img/icons/have_owe/assets/{{items.assetName}}.png" alt="icon" width="31" height="31">
							</div>
							<span>{{assetsTypeList[items.assetName]}}</span>
							<span>Me: {{items.assetsEstimation/2 | currency:"$":0}} <br />Spouse: {{items.assetsEstimation/2 | currency:"$":0}}</span>
						</div>
						<div>
							<a ng-click="edit(items.id, 'assets')">Edit</a>
						</div>
					</li>
				</ul>
			</div>
			<div ng-if="models.listDebt.shared.length" class="col-lg-12">
				<h2 class="reviewInnerTypeHead">Debts</h2>
				<ul>
					<li ng-repeat="items in models.listDebt.shared">
						<div>
							<div class="icon">
								<img src="static/img/icons/have_owe/debts/{{items.debtType}}.png" alt="icon" width="31" height="31">
							</div>
							<span>{{debtTypeList[items.debtType]}}</span>
							<span class="red">Me: -{{items.howMuchDebtGot | currency:"$":0}} <br />Spouse: -{{items.howMuchDebtGotSpouse | currency:"$":0}} </span>
						</div>
						<div>
							<a ng-click="edit(items.id, 'debt')">Edit</a>
						</div>
					</li>
				</ul>
			</div>
			<div class="col-lg-12">
				<div class="total_sec">
					<div class="backtoDash">
						<a href="" ng-click="gobackHaveOwe()">+ Add Assets and Debts</a>
					</div>
					<div class="total_val">
						My Total: {{((total.assetsTotal.shared/2)-total.debtTotal.shared.me) | currency:"$":0}}<br /> Spouse's Total: {{((total.assetsTotal.shared/2)-total.debtTotal.shared.spouse) | currency:"$":0}}
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
<div ng-if="editPopUpSec" class="haveOweEditPopup" id="editPopUpSec">
	<div class="editPopUpSecIn">
		<div class="editPopUpSecInIn">
			<div ng-include src="tempEdit"></div>
		</div>
		<a class="popup-close" data-popup-close="popup-1" ng-click="editPopUpClose()">x</a>
	</div>
</div>
<script type="text/ng-template" id="addNewAssetsForm">
	<form name="addAssetsForm" novalidate>
		<!-- <div class="row">
			<div class="col-lg-12">
				<p>
					Who does the asset belong to?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<md-radio-group ng-model="addAssetsData.assetBelongto" 
						name="assetBelongto" 
						class="{{(addAssetsValidate) ? (addAssetsForm.assetBelongto.$valid ? 'valid' : 'error') : ''}}"
						required>
				    	<md-radio-button value="Me" class="md-primary">Me</md-radio-button>
				    	<md-radio-button value="Spouse" class="md-primary">Spouse</md-radio-button>
				    </md-radio-group>
				</p>				
			</div>
		</div> -->
		<div class="row">
			<div class="col-lg-7">
				<p class="asft">Add Your Asset</p>
				<div class="{{(addAssetsValidate) ? (addAssetsForm.assetName.$valid ? 'valid' : 'error') : ''}}">
					<!-- <md-select placeholder="What type of asset?" ng-model="addAssetsData.assetName" data-md-container-class="selectdemoSelectHeader" required>
			            <md-option ng-value="$index" ng-repeat="vegetable in assetsTypeList">
			              <img ng-if="!$first" height="41px" width="41px" src="static/img/icons/have_owe/assets/{{$index}}.png"><span>{{$first ? 'What type of asset?' : vegetable}}</span>
			            </md-option>
			        </md-select>	 -->
			        <select custom-select="" ng-model="addAssetsData.assetName" name="assetName" ng-required="true" required>
			        	<option value="" src="">What type of asset?</option>
			        	<option value="1" src="static/img/icons/have_owe/assets/1.png">Checking Account</option>
			        	<option value="2" src="static/img/icons/have_owe/assets/2.png">Savings Account</option>
			        	<option value="3" src="static/img/icons/have_owe/assets/3.png">Investment Account</option>
			        	<option value="4" src="static/img/icons/have_owe/assets/4.png">Qualified Retirement Account</option>
			        	<option value="5" src="static/img/icons/have_owe/assets/5.png">Non-Qualified retirement account</option>
			        	<option value="6" src="static/img/icons/have_owe/assets/6.png">Personal Item</option>
			        	<option value="7" src="static/img/icons/have_owe/assets/7.png">Vehicle</option>
			        	<option value="8" src="static/img/icons/have_owe/assets/8.png">Property</option>
			        	<option value="9" src="static/img/icons/have_owe/assets/9.png">Pets</option>
			        </select>

			        <!-- <div custom-select="t as t for t in assetsTypeList" ng-model="person">
		                <div class="pull-left" style="width: 40px">
		                    <img ng-src="{{ t.picture }}" style="width: 30px" />
		                </div>
		                <div class="pull-left">
		                    <strong>{{ t }}</strong><br />
		                    <span>{{ t.subtitle }}</span>
		                </div>
		                <div class="clearfix"></div>
		            </div> -->
				</div>
				<div>
					<input 
			        	type="text" 
			        	class="asNa {{(addAssetsValidate) ? (addAssetsForm.assetTypeName.$valid ? 'valid' : 'error') : ''}}" 
			        	name="assetTypeName" 
			        	ng-model="addAssetsData.assetTypeName" 
			        	placeholder='Name this asset, e.g. "AUDI SUV"' 
			        	required>					
				</div>
			</div>
			<div class="col-lg-5">
				<a href="" class="asCn" ng-click="addNewClose('assets')">Cancel</a>
				<button ng-if="addAssetsForm.$valid" ng-disabled="addAssetsForm.$invalid" ng-click="addAssets(addAssetsData)">Add Asset</button>
				<button ng-if="addAssetsForm.$invalid" ng-click="validateAddAssets()">Add Asset</button>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-lg-12">
				<div class="keepAssetsleft">
					<p>Who will keep this asset?</p>
				</div>	
				<div class="keepAssetsright">
					<P>
						<md-radio-group ng-model="addAssetsData.whoWillKeep"
							name="whoWillKeep"
							class="{{(addAssetsValidate) ? (addAssetsForm.whoWillKeep.$valid ? 'valid' : 'error') : ''}}"
							required>
					    	<md-radio-button value="me" class="md-primary">I will</md-radio-button>
					    	<md-radio-button value="spouse" class="md-primary">My spouse will</md-radio-button>
					    	<md-radio-button value="shared" class="md-primary">We will equally divide this asset</md-radio-button>
					    </md-radio-group>	
					</P>
				</div>
			</div>
		</div>
		<!-- <div class="row">
			<div class="col-lg-12">
				<p class="content">Give us a short description of the asset. Include specifics about the asset, including <br />
				partial account id or identification number. For example, Wells Fargo Checking ending <br />
				in 0012, 2014 AUDI SUV VIN ending U76454, IRA Rollover, etc. Your documents will <br />
				be considered incomplete without this information.</p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<textarea ng-model="addAssetsData.description" 
					name="description" 
					class="{{(addAssetsValidate) ? (addAssetsForm.description.$valid ? 'valid' : 'error') : ''}}" 
					required></textarea>
			</div>
		</div> -->
		<div class="row">
			<div class="col-lg-12">
				<p>
					Did you acquire this asset in your marriage or separately?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<md-radio-group ng-model="addAssetsData.acquireAssets"
						name="acquireAssets"
						class="{{(addAssetsValidate) ? (addAssetsForm.acquireAssets.$valid ? 'valid' : 'error') : ''}}"
						required>
				    	<md-radio-button value="Separately" class="md-primary">Separately</md-radio-button>
				    	<md-radio-button value="In marriage" class="md-primary">In marriage</md-radio-button>
				    </md-radio-group>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-7">
				<p class="discr_content">What date did you acquire this asset?</p>
			</div>
			<div class="col-lg-4">
				<!-- <div 
					datepicker 
					date-max-limit="{{today | date:'yyyy/MM/dd'}}" 
					date-format="MM/dd/yyyy"
					date-typer="false">
			        <input 
			        	ng-model="addAssetsData.acquireAssetsDate" 
			        	type="text" 
			        	name="acquireAssetsDate" 
			        	class="angular-datepicker-input {{(addAssetsValidate) ? (addAssetsForm.acquireAssetsDate.$valid ? 'valid' : 'error') : ''}}"
			        	placeholder="MM/DD/YYYY"
			        	required 
			        	/>
			    </div>	 -->
			    <input 
			    	type="text" 
			    	class="{{(addAssetsValidate) ? (addAssetsForm.acquireAssetsDate.$valid ? 'valid' : 'error') : ''}}"
			    	ng-model="addAssetsData.acquireAssetsDate" 
			    	name="acquireAssetsDate" 
			    	ui-date="{dateFormat: 'mm/dd/yy'}" 
			    	placeholder="MM/DD/YYYY" 
			    	required />
			</div>
		</div>
		<div class="row">
			<div class="col-lg-7">
				<p class="discr_content">What is the estimated value?</p>
			</div>
			<div class="col-lg-5">
				<input type="text" 
					name="assetsEstimation" 
					class="{{(addAssetsValidate) ? (addAssetsForm.assetsEstimation.$valid ? 'valid' : 'error') : ''}}"
					ng-model="addAssetsData.assetsEstimation" 
					validate="false" 
					restrict="reject"
					clean="true"
					limit="false"  
					mask="$99999999999999"
					placeholder="$000,000,000" 
					required>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-7">
				<p class="discr_content">Amount of loans or outstanding debt against this item</p>
			</div>
			<div class="col-lg-5">
				<input 
					type="text" 
					name="outstandingLoan" 
					ng-model="addAssetsData.outstandingLoanValue" 
					placeholder="$000,000,000" 
					class="{{(addAssetsValidate) ? (addAssetsForm.outstandingLoan.$valid ? 'valid' : 'error') : ''}}"
					validate="false" 
					restrict="reject"
					clean="true"
					limit="false"  
					mask="$99999999999999"
					required>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12">
				<!-- <p>Do you have any additional details to add about this asset? For example, plans to close or transfer financial accounts, changing the title on cars, arrangements for dividing up personal items like furniture.</p> -->
				<p class="asdesc">
					Provides a short description of the asset.<br>
					Includes specifics, including partial account id or identification number. <br>
					For example, Wells Fargo Checking ending in #0012. <br>
					<a href="">Your documents will be incomplete without a description.</a>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<textarea ng-model="addAssetsData.additionalDetails" name="additional"></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-7">
				<label ng-if="addAssetsValidate && addAssetsForm.$invalid" class="error">Your form is missing information. Please check your responses.</label>
			</div>
			<div class="col-lg-5">
				<a href="" class="asCn" ng-click="addNewClose('assets')">Cancel</a>
				<button ng-if="addAssetsForm.$valid" ng-disabled="addAssetsForm.$invalid" ng-click="addAssets(addAssetsData)">Add Asset</button>
				<button ng-if="addAssetsForm.$invalid" ng-click="validateAddAssets()">Add Asset</button>
			</div>
		</div>
	</form>
</script>
<script type="text/ng-template" id="addNewDebtForm">
	<form name="addDebtForm" novalidate>
		<!-- <div class="row">
			<div class="col-lg-12">
				<p>
					Who does the Debt belong to?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<md-radio-group ng-model="addDebtValue.belongTo" 
						name="belongTo"
						class="{{(addDebtValidate) ? (addDebtForm.belongTo.$valid ? 'valid' : 'error') : ''}}"
						required>
				    	<md-radio-button value="Me" class="md-primary">Me</md-radio-button>
				    	<md-radio-button value="Spouse" class="md-primary">Spouse</md-radio-button>
				    </md-radio-group>
				</p>				
			</div>
		</div> -->
		<div class="row">
			<div class="col-lg-7">
				<p>Add Your Debt</p>
				<div class="{{(addDebtValidate) ? (addDebtForm.debttype.$valid ? 'valid' : 'error') : ''}}">
					<select custom-select="" ng-model="addDebtValue.debtType" name="debttype" ng-required="true" required>
						<option value="" src="">What type of debt?</option>
			        	<option value="1" src="static/img/icons/have_owe/debts/1.png">Credit card</option>
			        	<option value="2" src="static/img/icons/have_owe/debts/2.png">Past due child or spousal support</option>
			        	<option value="3" src="static/img/icons/have_owe/debts/3.png">Personal loans</option>
			        	<option value="4" src="static/img/icons/have_owe/debts/4.png">Student loans</option>
			        	<option value="5" src="static/img/icons/have_owe/debts/5.png">Taxes</option>
			        	<option value="6" src="static/img/icons/have_owe/debts/6.png">Property</option>
					</select>
					
					<!-- <md-select placeholder="What type of debt?" ng-model="addDebtValue.debtType" data-md-container-class="selectdemoSelectHeader" required>
			            <md-option ng-value="$index" ng-repeat="vegetable in debtTypeList">
			              <img ng-if="!$first" height="41px" width="41px" src="static/img/icons/have_owe/debts/{{$index}}.png"><span>{{$first ? 'What type of debt?' : vegetable}}</span>
			            </md-option>
			        </md-select>	 -->
				</div>
				<div>
					<input 
						type="text" 
						name="debtTypeName" 
						ng-model="addDebtValue.debtTypeName"
						class="adna {{(addDebtValidate) ? (addDebtForm.debtTypeName.$valid ? 'valid' : 'error') : ''}}" 
						placeholder='Name this debt, e.g. "Main st Mtg Pmyt"'
						required>
				</div>
			</div>
			<div class="col-lg-5">
				<a href="" class="adCn" ng-click="addNewClose('debt')">Cancel</a>
				<button ng-if="addDebtForm.$valid" ng-disabled="addDebtForm.$invalid" ng-click="addDebt(addDebtValue)" >Add Debt</button>
				<button ng-if="addDebtForm.$invalid" ng-click="validateAddDebt()">Add Debt</button>
			</div>
		</div>
		<!-- <div class="row">
			<div class="col-lg-12">
				<p class="content">Give us a short description of the debt. Include specifics about the debt, including <br />
				partial account id or identification number. For example, Bank of American credit card <br />
				ending in 0012, FAFSA loan number ending 6454 2014 IRS taxes, etc. Your documents <br />
				will be considered incomplete without this information.</p>
			</div>
		</div> -->
		<!-- <div class="row">
			<div class="col-lg-12">
				<textarea ng-model="addDebtValue.description" 
					name="description" 
					class="{{(addDebtValidate) ? (addDebtForm.description.$valid ? 'valid' : 'error') : ''}}"
					required></textarea>
			</div>
		</div> -->
		<br>
		<div class="row">
			<div class="col-lg-12">
				<p>
					Did you acquire this debt in your marriage or separately?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<md-radio-group ng-model="addDebtValue.acquireDeby" 
						name="acquireDeby"
						class="{{(addDebtValidate) ? (addDebtForm.acquireDeby.$valid ? 'valid' : 'error') : ''}}"
						required>
				    	<md-radio-button value="Separately" class="md-primary">Separately</md-radio-button>
				    	<md-radio-button value="In marriage" class="md-primary">In marriage</md-radio-button>
				    </md-radio-group>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<p class="discr_content">What date did you acquire this debt?</p>
			</div>
			<div class="col-lg-4">
				<!-- <div 
					datepicker 
					date-max-limit="{{today | date:'yyyy/MM/dd'}}" 
					date-format="MM/dd/yyyy"
					date-typer="false">
			        <input 
			        	ng-model="addDebtValue.acquireDebyDate" 
			        	type="text" 
			        	class="angular-datepicker-input {{(addDebtValidate) ? (addDebtForm.acquireDebyDate.$valid ? 'valid' : 'error') : ''}}"
			        	placeholder="MM/DD/YYYY"
			        	name="acquireDebyDate" 
			        	required 
			        	/>
			    </div> -->	
			    <input 
			    	type="text" 
			    	class="{{(addDebtValidate) ? (addDebtForm.acquireDebyDate.$valid ? 'valid' : 'error') : ''}}"
			    	ng-model="addDebtValue.acquireDebyDate" 
			    	name="acquireDebyDate" 
			    	ui-date="{dateFormat: 'mm/dd/yy'}" 
			    	placeholder="MM/DD/YYYY" 
			    	required />
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<p class="discr_content">What is the estimated outstanding debt?</p>
			</div>
			<div class="col-lg-4">
				<input type="text" 
					name="estimation" 
					ng-model="addDebtValue.debyEstimation" 
					class="{{(addDebtValidate) ? (addDebtForm.estimation.$valid ? 'valid' : 'error') : ''}}"
					validate="false" 
					restrict="reject"
					clean="true"
					limit="false"  
					mask="$99999999999999"
					placeholder="$000,000,000" 
					required>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<p class="discr_content">How much of this debt will go to you?</p>
			</div>
			<div class="col-lg-4">
				<input type="text" 
					name="howMuchDebtGot" 
					ng-model="addDebtValue.howMuchDebtGot" 
					class="{{(addDebtValidate) ? (addDebtForm.howMuchDebtGot.$valid ? 'valid' : 'error') : ''}}"
					validate="false" 
					restrict="reject"
					clean="true"
					limit="false"  
					mask="$99999999999999"
					placeholder="$000,000,000" required>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<p class="discr_content">How much of this debt will go to your spouse?</p>
			</div>
			<div class="col-lg-4">
				<input type="text" 
					name="howMuchDebtGotSpouse" 
					ng-model="addDebtValue.howMuchDebtGotSpouse" 
					placeholder="$000,000,000" 
					class="{{(addDebtValidate) ? (addDebtForm.howMuchDebtGotSpouse.$valid ? 'valid' : 'error') : ''}}"
					validate="false" 
					restrict="reject"
					clean="true"
					limit="false"  
					mask="$99999999999999"
					maxlength="20" 
					required>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-9">
				<p>
					Will you have a monthly payment associated with this debt?
				</p>
			</div>
			<div class="col-lg-3">
				<p>
					<md-radio-group ng-model="addDebtValue.monthlyPay"
						name="monthlyPay"
						class="{{(addDebtValidate) ? (addDebtForm.monthlyPay.$valid ? 'valid' : 'error') : ''}}"
						required>
				    	<md-radio-button value="Yes" class="md-primary">Yes</md-radio-button>
				    	<md-radio-button value="No" class="md-primary">No</md-radio-button>
				    </md-radio-group>
				</p>				
			</div>
		</div>
		<div class="row">
			<div class="col-lg-9">
				<p>
					Will your spouse have a monthly payment associated with this debt?
				</p>
			</div>
			<div class="col-lg-3">
				<p>
					<md-radio-group ng-model="addDebtValue.monthlyPaySpouse" 
						name="monthlyPaySpouse"
						class="{{(addDebtValidate) ? (addDebtForm.monthlyPaySpouse.$valid ? 'valid' : 'error') : ''}}"
						required>
				    	<md-radio-button value="Yes" class="md-primary">Yes</md-radio-button>
				    	<md-radio-button value="No" class="md-primary">No</md-radio-button>
				    </md-radio-group>
				</p>				
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<!-- <p>Do you have any additional details to add about this debt? For example, plans to close or transfer financial accounts, changing the titles, arrangements for dividing up loans...</p> -->
				<p class="addesc">
					Provide a short description of the debt. <br>
					Include specifics, including partial account id or identification number. <br>
					For example, Nordstrom account ending in #8551. <br>
					<a href="">Your documents will be incomplete without a description</a>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<textarea ng-model="addDebtValue.additional"></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-7">
				<label ng-if="addDebtValidate && addDebtForm.$invalid" class="error">Your form is missing information. Please check your responses.</label>
			</div>
			<div class="col-lg-5">
				<a href="" class="adCn" ng-click="addNewClose('debt')">Cancel</a>
				<button ng-if="addDebtForm.$valid" ng-disabled="addDebtForm.$invalid" ng-click="addDebt(addDebtValue)" >Add Debt</button>
				<button ng-if="addDebtForm.$invalid" ng-click="validateAddDebt()">Add Debt</button>
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
							<p>{{list.type == 'assets' ? assetsTypeList[list.assetName] : debtTypeList[list.debtType] }}</p>
						</div>
						<div class="divTableCell">
							<p>
								{{list.type == 'assets' ? (list.assetsEstimation | currency:"$":0) : (-list.debyEstimation | currency:"$":0) }}
							</p>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>
<script type="text/ng-template" id="editPopUpAssets">
	<div class="editPopUpSecAssets">
		<form name="editAssetsForm" novalidate>
			<!-- <div class="row">
				<div class="col-lg-12">
					<p>
						Who does the asset belong to?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<md-radio-group ng-model="editAssetsData.assetBelongto" name="assetBelongto" required>
					    	<md-radio-button value="Me" class="md-primary">Me</md-radio-button>
					    	<md-radio-button value="Spouse" class="md-primary">Spouse</md-radio-button>
					    </md-radio-group>
					</p>				
				</div>
			</div> -->
			<div class="row">
				<div class="col-lg-7">
					<!-- <md-select placeholder="What type of asset?" ng-model="editAssetsData.assetName" data-md-container-class="selectdemoSelectHeader" required>
			            <md-option ng-value="$index" ng-repeat="vegetable in assetsTypeList" ng-if="!$first">
			              <img ng-if="!$first" height="41px" width="41px" src="static/img/icons/have_owe/assets/{{$index}}.png"><span>{{$first ? 'What type of asset?' : vegetable}}</span>
			            </md-option>
			        </md-select> -->
			        <select custom-select="" ng-model="editAssetsData.assetName" name="assetName" ng-required="true" required>
			        	<option value="" src="">What type of asset?</option>
			        	<option value="1" src="static/img/icons/have_owe/assets/1.png">Checking Account</option>
			        	<option value="2" src="static/img/icons/have_owe/assets/2.png">Savings Account</option>
			        	<option value="3" src="static/img/icons/have_owe/assets/3.png">Investment Account</option>
			        	<option value="4" src="static/img/icons/have_owe/assets/4.png">Qualified Retirement Account</option>
			        	<option value="5" src="static/img/icons/have_owe/assets/5.png">Non-Qualified retirement account</option>
			        	<option value="6" src="static/img/icons/have_owe/assets/6.png">Personal Item</option>
			        	<option value="7" src="static/img/icons/have_owe/assets/7.png">Vehicle</option>
			        	<option value="8" src="static/img/icons/have_owe/assets/8.png">Property</option>
			        	<option value="9" src="static/img/icons/have_owe/assets/9.png">Pets</option>
			        </select>
			        <br>
			        <div>
						<input 
				        	type="text" 
				        	class="asNa {{(addAssetsValidate) ? (addAssetsForm.assetTypeName.$valid ? 'valid' : 'error') : ''}}" 
				        	name="assetTypeName" 
				        	ng-model="editAssetsData.assetTypeName" 
				        	placeholder='Name this asset, e.g. "AUDI SUV"' 
				        	required>					
					</div>
				</div>
				<div class="col-lg-5">
				</div>
			</div>
			<!-- <div class="row">
				<div class="col-lg-12">
					<p class="content">Give us a short description of the asset. Include specifics about the asset, including <br />
					partial account id or identification number. For example, Wells Fargo Checking ending <br />
					in 0012, 2014 AUDI SUV VIN ending U76454, IRA Rollover, etc. Your documents will <br />
					be considered incomplete without this information.</p>
				</div>
			</div> -->
			<!-- <div class="row">
				<div class="col-lg-12">
					<textarea ng-model="editAssetsData.description" name="description" required></textarea>
				</div>
			</div> -->
			<div class="row">
				<div class="col-lg-12">
					<p>
						Did you acquire this asset in your marriage or separately?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<md-radio-group ng-model="editAssetsData.acquireAssets" name="acquireAssets"	required>
					    	<md-radio-button value="Separately" class="md-primary">Separately</md-radio-button>
					    	<md-radio-button value="In marriage" class="md-primary">In marriage</md-radio-button>
					    </md-radio-group>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<p class="discr_content">What date did you acquire this asset?</p>
				</div>
				<div class="col-lg-4">
					<!-- <input 
						type="text" 
						name="acquireAssetsDate" 
						ng-model="editAssetsData.acquireAssetsDate" 
						placeholder="MM/DD/YYYY"
						restrict="reject" 
						mask="19/39/2999"
						required> -->
					<input 
				    	type="text" 
				    	class="{{(addDebtValidate) ? (editDebtForm.acquireAssetsDate.$valid ? 'valid' : 'error') : ''}}"
				    	ng-model="editAssetsData.acquireAssetsDate" 
				    	name="acquireAssetsDate" 
				    	ui-date="{dateFormat: 'mm/dd/yy'}" 
				    	placeholder="MM/DD/YYYY" 
				    	required />
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<p class="discr_content">What is the estimated value?</p>
				</div>
				<div class="col-lg-4">
					<input 
						type="text" 
						name="assetsEstimation" 
						ng-model="editAssetsData.assetsEstimation" 
						placeholder="$000,000,000" 
						validate="false" 
						restrict="reject"
						clean="true"
						limit="false"  
						mask="$"
						maxlength="20" 
						required>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<p class="discr_content">Amount of loans or outstanding debt against this item</p>
				</div>
				<div class="col-lg-4">
					<input 
						type="text" 
						name="outstandingLoan" 
						ng-model="editAssetsData.outstandingLoanValue" 
						placeholder="$000,000,000" 
						validate="false" 
						restrict="reject"
						clean="true"
						limit="false"  
						mask="$"
						maxlength="20" 
						required>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="keepAssetsleft">
						<p>Who will keep this asset?</p>
					</div>	
					<div class="keepAssetsright">
						<P>
							<md-radio-group ng-model="editAssetsData.whoWillKeep" name="whoWillKeep" required>
						    	<md-radio-button value="me" class="md-primary">Petitioner</md-radio-button>
						    	<md-radio-button value="spouse" class="md-primary">Respondent</md-radio-button>
						    	<md-radio-button value="shared" class="md-primary">We will equally divide this asset</md-radio-button>
						    </md-radio-group>	
						</P>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<!-- <p>Do you have any additional details to add about this asset? For example, plans to close or transfer financial accounts, changing the title on cars, arrangements for dividing up personal items like furniture.</p> -->
					<p class="asdesc">
						Provides a short description of the asset.<br>
						Includes specifics, including partial account id or identification number. <br>
						For example, Wells Fargo Checking ending in #0012. <br>
						<a href="">Your documents will be incomplete without a description.</a>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<textarea ng-model="editAssetsData.additionalDetails" name="additional"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<button ng-click="editAssets(editAssetsData)">Update Asset</button>
				</div>
			</div>
		</form>
	</div>
	
</script>
<script type="text/ng-template" id="editPopUpDebt">
	<div class="editPopUpSecDebt">
		<form name="editDebtForm" novalidate>
			<!-- <div class="row">
				<div class="col-lg-12">
					<p>
						Who does the Debt belong to?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<md-radio-group ng-model="editDebtValue.belongTo" name="belongTo" required>
					    	<md-radio-button value="Me" class="md-primary">Me</md-radio-button>
					    	<md-radio-button value="Spouse" class="md-primary">Spouse</md-radio-button>
					    </md-radio-group>
					</p>				
				</div>
			</div> -->
			<div class="row">
				<div class="col-lg-7">
					<!-- <md-select placeholder="What type of debt?" ng-model="editDebtValue.debtType" data-md-container-class="selectdemoSelectHeader" required>
			            <md-option ng-value="$index" ng-repeat="vegetable in debtTypeList" ng-if="!$first">
			              <img ng-if="!$first" height="41px" width="41px" src="static/img/icons/have_owe/debts/{{$index}}.png"><span>{{$first ? 'What type of debt?' : vegetable}}</span>
			            </md-option>
			        </md-select> -->
			        <select custom-select="" ng-model="editDebtValue.debtType" name="debtType" ng-required="true" required>
			        	<option value="" src="">What type of debt?</option>
			        	<option value="1" src="static/img/icons/have_owe/debts/1.png">Credit card</option>
			        	<option value="2" src="static/img/icons/have_owe/debts/2.png">Past due child or spousal support</option>
			        	<option value="3" src="static/img/icons/have_owe/debts/3.png">Personal loans</option>
			        	<option value="4" src="static/img/icons/have_owe/debts/4.png">Student loans</option>
			        	<option value="5" src="static/img/icons/have_owe/debts/5.png">Taxes</option>
			        	<option value="6" src="static/img/icons/have_owe/debts/6.png">Property</option>
			        </select>
			        <br>
			        <div>
						<input 
							type="text" 
							name="debtTypeName" 
							ng-model="editDebtValue.debtTypeName"
							class="adna {{(addDebtValidate) ? (addDebtForm.debtTypeName.$valid ? 'valid' : 'error') : ''}}" 
							placeholder='Name this debt, e.g. "Main st Mtg Pmyt"'
							required>
					</div>
				</div>
				<div class="col-lg-5">
				</div>
			</div>
			<!-- <div class="row">
				<div class="col-lg-12">
					<p class="content">Give us a short description of the debt. Include specifics about the debt, including <br />
					partial account id or identification number. For example, Bank of American credit card <br />
					ending in 0012, FAFSA loan number ending 6454 2014 IRS taxes, etc. Your documents <br />
					will be considered incomplete without this information.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<textarea ng-model="editDebtValue.description" name="description" required></textarea>
				</div>
			</div> -->
			<div class="row">
				<div class="col-lg-12">
					<p>
						Did you acquire this debt in your marriage or separately?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<md-radio-group ng-model="editDebtValue.acquireDeby" name="acquireDeby" required>
					    	<md-radio-button value="Separately" class="md-primary">Separately</md-radio-button>
					    	<md-radio-button value="In marriage" class="md-primary">In marriage</md-radio-button>
					    </md-radio-group>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<p class="discr_content">What date did you acquire this debt?</p>
				</div>
				<div class="col-lg-4">
					<!-- <input 
						type="text" 
						name="acquireDebyDate" 
						ng-model="editDebtValue.acquireDebyDate" 
						placeholder="MM/DD/YYYY"
						mask="19/39/2999"
						restrict="reject" 
						required> -->
					<input 
				    	type="text" 
				    	class="{{(addDebtValidate) ? (editDebtForm.acquireDebyDate.$valid ? 'valid' : 'error') : ''}}"
				    	ng-model="editDebtValue.acquireDebyDate" 
				    	name="acquireDebyDate" 
				    	ui-date="{dateFormat: 'mm/dd/yy'}" 
				    	placeholder="MM/DD/YYYY" 
				    	required />
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<p class="discr_content">What is the estimated outstanding debt?</p>
				</div>
				<div class="col-lg-4">
					<input type="text" 
						name="debyEstimation" 
						validate="false" 
						restrict="reject"
						clean="true"
						limit="false"  
						mask="$"
						maxlength="20" 
						ng-model="editDebtValue.debyEstimation" 
						placeholder="$000,000,000"
						required>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<p class="discr_content">How much of this debt will go to you?</p>
				</div>
				<div class="col-lg-4">
					<input type="text" name="howMuchDebtGot" 
						ng-model="editDebtValue.howMuchDebtGot" 
						validate="false" 
						restrict="reject"
						clean="true"
						limit="false"  
						mask="$"
						maxlength="20" 
						placeholder="$000,000,000"
						required>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<p class="discr_content">How much of this debt will go to your spouse?</p>
				</div>
				<div class="col-lg-4">
					<input type="text" name="howMuchDebtGotSpouse" 
						ng-model="editDebtValue.howMuchDebtGotSpouse" 
						validate="false" 
						restrict="reject"
						clean="true"
						limit="false"  
						mask="$"
						maxlength="20" 
						placeholder="$000,000,000"
						required>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-9">
					<p>
						Will you have a monthly payment associated with this debt?
					</p>
				</div>
				<div class="col-lg-3">
					<p>
						<md-radio-group ng-model="editDebtValue.monthlyPay" name="monthlyPay" required>
					    	<md-radio-button value="Yes" class="md-primary">Yes</md-radio-button>
					    	<md-radio-button value="No" class="md-primary">No</md-radio-button>
					    </md-radio-group>
					</p>				
				</div>
			</div>
			<div class="row">
				<div class="col-lg-9">
					<p>
						Will your spouse have a monthly payment associated with this debt?
					</p>
				</div>
				<div class="col-lg-3">
					<p>
						<md-radio-group ng-model="editDebtValue.monthlyPaySpouse" name="monthlyPaySpouse" required>
					    	<md-radio-button value="Yes" class="md-primary">Yes</md-radio-button>
					    	<md-radio-button value="No" class="md-primary">No</md-radio-button>
					    </md-radio-group>
					</p>				
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<!-- <p>Do you have any additional details to add about this debt? For example, plans to close or transfer financial accounts, changing the titles, arrangements for dividing up loans...</p> -->
					<p class="addesc">
						Provide a short description of the debt. <br>
						Include specifics, including partial account id or identification number. <br>
						For example, Nordstrom account ending in #8551. <br>
						<a href="">Your documents will be incomplete without a description</a>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<textarea ng-model="editDebtValue.additional"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
						
					<button ng-click="editDebt(editDebtValue)">Update Debt</button>
				</div>
			</div>
		</form>
	</div>
	
</script>
<script type="text/ng-template" id="haveOweReview">
	<div>
		
	</div>
</script>