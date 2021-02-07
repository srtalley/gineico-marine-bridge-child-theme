<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
		<style type="text/css">
			a {
				color: #242e4a;
			}
			#template_header {
				background-color: #CEC6B1;
			}
			#header_wrapper {
				padding: 16px 18px;
				line-height: 1.3em;
				border-bottom: 1px solid #c2c2c2;
				vertical-align: middle;
				text-align: center;
			}
			h2.body-title {
				font-size: 22px; 
				text-align: left; 
				font-weight: bold; 
				color: #232323;
			}
			p {
				color: #232323;
				font-size: 16px;
				margin: 10px 0 !important;
			}
			.wc-item-meta li p {
				margin: 0 !important;
				font-size: 14px !important;
			}
			table.td {
				background: #f7f7f7;
			}
			table.td thead th.td,
			thead tr.order_item th {
				text-transform: uppercase;
				font-size: 10px;
				padding-top: 5px !important;
				padding-bottom: 5px !important;
				border: none !important;
			}
			table.td .order_item .td,
			tr.order_item > th,
			tr.order_item > td{
				border-left: none !important;
				border-right: none !important;
				color: #232323;
			}
			.order_item a {
				text-decoration: none;
				font-weight: bold;
			}
			table.td tfoot th.td,
			table.td tfoot td.td,
			tr.order_item.tfoot th{
				border-top-width: 1px !important;
				text-transform: uppercase;
				border-left: none !important;
				border-right: none !important;
				color: #232323 !important;
			}
			table.td tfoot td.td {
				border-top-width: 1px !important;
				border-left: none !important;
				border-right: none !important;
			}
			.subtotal_items_wrapper {
				padding: 0 !important;
			}
			.subtotal_items th,
			.subtotal_items td {
				border: none !important;
			}
			.footer_container_inner p {
				font-size: 12px !important;
			}
			.footer_container_inner a {
				text-decoration: none;
			}
			.currency-suffix {
				font-size: 12px;
				display: block;
			}
			.wc-item-meta li strong,
			.wc-item-meta li p {
				display: inline-block;
			}
			span.im,
			.im li {
				color: #232323 !important;
			}
		</style>
	</head>
	<body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		<div id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
			<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
				<tr>
					<td align="center" valign="top">
						
						<table border="0" cellpadding="0" cellspacing="0" width="700" id="template_container">
							<tr>
								<td align="center" valign="top">
									<!-- Header -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header">
										<tr>
											<td id="header_wrapper">
												<div id="template_header_image">
													<?php
													if ( $img = get_option( 'woocommerce_email_header_image' ) ) {
														echo '<p style="margin-top:0 !important; margin-bottom: 0 !important;"><a href="' . site_url() . '" target="_blank"><img width="200" height="104" src="' . esc_url( $img ) . '" alt="' . get_bloginfo( 'name', 'display' ) . '" style="width: 200px; margin-top: 10px;" /><a/></p>';
													}
													?>
													<p style="font-size: 14px; font-weight: normal; margin: 0 !important;">Gineico Marine • Italian Marine Accessories</p>
												</div>
											</td>
										</tr>
										<tr style="font-family: Arial,sans-serif; line-height: 1.3em;">
											<td align="center" valign="top" class="nav_holder top_nav_holder" style="font-family: Arial, sans-serif; line-height: 1.3em; background: #fafafa; border-bottom: 1px solid #f5f5f5;">
												<table border="0" cellpadding="0" cellspacing="0" width="auto" class="top_nav" style="font-family: Arial, sans-serif; line-height: 1.3em; color: #232323;">
													<tbody>
														<tr style="font-family: Arial, sans-serif; line-height: 1.3em;">
															<td class="nav-spacer-block" style="font-family: Arial, sans-serif; line-height: 1.3em; height: 38px;font-size: 14px; padding: 8px 6px;">&nbsp;
															</td>
															<td class="nav-text-block " style="font-family: Arial, sans-serif; line-height: 1.3em; height: 38px; font-size: 14px; padding: 8px 12px;">
																<a href="https://www.gineicomarine.com.au/products/" style="color: #232323; font-style: none; text-decoration: none;"> Products </a>
															</td>
															<td class="nav-text-block " style="font-family: Arial, sans-serif; line-height: 1.3em; height: 38px; font-size: 14px; padding: 8px 12px;"> <a href="https://www.gineicomarine.com.au/my-account/" style="color: #232323; font-style: none; text-decoration: none;"> My Account </a>
															</td>
															<td class="nav-text-block " style="font-family: Arial, sans-serif; line-height: 1.3em; height: 38px; font-size: 14px; padding: 8px 12px;">
																<a href="https://www.gineicomarine.com.au/contact-us/" style="color: #232323; font-style: none; text-decoration: none;"> Contact Us </a> 
															</td>
															<td class="nav-spacer-block" style="font-family: Arial, sans-serif; line-height: 1.3em; height: 38px; font-size: 14px; padding: 8px 6px;">&nbsp;
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</table>
									<!-- End Header -->
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<!-- Body -->
									<table border="0" cellpadding="0" cellspacing="0" width="700" id="template_body">
										<tr>
											<td valign="top" id="body_content">
												<!-- Content -->
												<table border="0" cellpadding="20" cellspacing="0" width="100%">
													<tr>
														<td valign="top">
															<div id="body_content_inner">
																<h2 class="body-title"><?php echo $email_heading; ?></h2>