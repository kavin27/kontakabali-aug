<section class="contactform-section">
				<div class="container">
					<div class="row">
						<h1>Contact Us</h1>
						<form name="contactform" id="contact-form" novalidate>
							<div class="col-sm-12">
								<input type="text" id="name" class="{{(error) ? (contactform.name.$valid ? 'valid' : 'error') : ''}}" name="name" ng-model="contact.name" placeholder="Name" required />
							</div>
							<div class="col-sm-12">
								<input type="text" class="{{(error) ? (contactform.phoneno.$valid ? 'valid' : 'error') : ''}}" id="phoneno" name="phoneno" ng-model="contact.phoneno" maxlength="10" placeholder="Phone" required />
							</div>
							<div class="col-sm-12">
								<input type="email" class="{{(error) ? (contactform.email.$valid ? 'valid' : 'error') : ''}}" id="email" name="email" ng-model="contact.email" placeholder="Email" required />
							</div>
							<div class="col-sm-12">
							<select id="question" ng-model="contact.question" name="question">
								<option value="">What is your question related to?</option>
								<option value="Child Custody">Child Custody</option>
								<option value="Co-parenting">Co-parenting</option>
								<option value="Spousal Support">Spousal Support</option>
								<option value="Community Property">Community Property</option>
								<option value="Taxes">Taxes</option>
								<option value="Other">Other</option>
							</select>
							</div>
							<div class="col-sm-12">
								<textarea name="message" ng-model="contact.message" placeholder="Message"></textarea>
							</div>
							<div class="col-sm-12 txt_align_center">
								<button ng-if="contactform.$valid" ng-click="submit(contact)" type="submit" value="submit" name="submit">Submit</button>
								<button ng-if="contactform.$invalid" ng-click="errorcal()" type="button" value="submit" name="submit">Submit</button>
							</div>
							<div class="sent sent-display" style="display: none;">Thank you for the Message</div>
						</form>
						<div class="egg-image">
							<img src="static/img/egg-image.png">
						</div>
					</div>
				</div>
			</section>