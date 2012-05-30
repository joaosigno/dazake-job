<?php
/*
Template Name: page-contact_us
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<?php get_header();?>
		
		<div id="contact_page">
			<div id="contact_info">
				<h3>Ztem Stone Creations</h3>
				<p>t : 852.2739.5519</p>
				<p>e : info@ztem.com</p>
				<p>Suit 2305, APEC Plaza,49 Hoi Yuen Road,</p>
				<p>Kwun Tong, Kowloon, Hong Kong</p>
			</div>
			<div id="contact_box">
				<h3>Tell us what you think...</h3>
				<form action="" id="contact_form">
					<label for="name">Name: </label>
					<input type="text" name="name" id="name" />
					<br />
					<label for="email">Email: </label>
					<input type="text" name="email" id="email" />
					<br />
					<label for="website">Website: </label>
					<input type="text" name="website" id="website" />
					<br />
					<label for="message">Message: </label>
					<br />
					<textarea name="message" id="message" cols="30" rows="10"></textarea>
					<br />

					<input type="submit" value="Submit" id="submit"/>
				</form>
			</div>
			<img src="<?php bloginfo('template_directory'); ?>/images/contact.png" height="486" width="599" alt="" class="contact-img" />
		</div>
	<?php get_footer();?>