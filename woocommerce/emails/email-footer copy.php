<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>
															</div>
														</td>
													</tr>
												</table>
												<!-- End Content -->
											</td>
										</tr>
									</table>
									<!-- End Body -->
								</td>
							</tr>
							<tr>
					<td align="center" valign="top">
						<!-- Footer -->


						<table cellpadding="0" cellspacing="0" border="0" width="700" style="font-family: Arial, sans-serif; line-height: 1.3em; color: #232323;">
							<tbody>
								<tr style="font-family: Arial, sans-serif; line-height: 1.3em;">
									<td width="100%" align="center" class="footer_container" style="line-height: 1.3em; font-family: Arial,sans-serif; font-size: 12px; text-align: center; padding: 12px 22.5px 16px; border-top: 1px solid #ededed; color: #646464; background-color: #fafafa;">
										<?php 
										if ( $img = get_option( 'woocommerce_email_header_image' ) ) {
											echo '<p style="margin-top:0 !important; margin-bottom: 0 !important;"><a href="' . site_url() . '" target="_blank"><img src="' . esc_url( $img ) . '" width="100" height="52" alt="' . get_bloginfo( 'name', 'display' ) . '" style="width: 100px;" /><a/></p>';
										} ?>
										<table align="center" cellpadding="0" cellspacing="0" border="0" width="auto" style="font-family: Arial, sans-serif; line-height: 1.3em; color: #232323;">
										<tbody>
											<tr style="font-family: Arial, sans-serif; line-height: 1.3em;">
												<td align="center" class="footer_container_inner bottom-nav" style="line-height: 1.3em; font-family: Arial,sans-serif; font-size: 12px; color: #646464;">
													<table border="0" cellpadding="0" cellspacing="0" width="auto" class="top_nav" style="font-family: Arial, sans-serif; line-height: 1.3em; color: #232323;">
													<tbody>
														<tr style="font-family: Arial, sans-serif; line-height: 1.3em;">
															<td class="nav-text-block " style="font-family: Arial, sans-serif; line-height: 1.3em; height: 18px; font-size: 11px; padding: 2px 6px;"> <a href="https://www.facebook.com/gineicomarine/" style="color: #232323; font-style: none; text-decoration: none;" target="_blank"> Facebook </a> </td>
															<td class="nav-text-block " style="font-family: Arial, sans-serif; line-height: 1.3em; height: 18px; font-size: 11px; padding: 2px 6px;"> <a href="https://www.instagram.com/gineico_marine/" style="color: #232323; font-style: none; text-decoration: none;" target="_blank"> Instagram </a> </td>
															<td class="nav-text-block " style="font-family: Arial, sans-serif; line-height: 1.3em; height: 18px; font-size: 11px; padding: 2px 6px;"> <a href="https://www.youtube.com/channel/UCoGkOukwxPVN0ENO_7ly4uA" style="color: #232323; font-style: none; text-decoration: none;" target="_blank"> YouTube </a> </td>
														</tr>
													</tbody>
													</table>
												</td>
											</tr>
										</tbody>
										</table>
										<table align="center" cellpadding="0" cellspacing="0" border="0" width="auto" style="font-family: Arial, sans-serif; line-height: 1.3em; color: #232323;">
										<tbody>
											<tr style="font-family: Arial, sans-serif; line-height: 1.3em;">
												<td align="center" class="footer_container_inner bottom-nav" style="line-height: 1.3em; font-family: Arial,sans-serif; font-size: 12px; color: #646464;">
													<?php echo wp_kses_post( wpautop( wptexturize( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) ) ) ); ?>
													</td>
												</tr>
											</tbody>
										</table>
										
										<table align="center" cellpadding="0" cellspacing="0" border="0" width="auto" style="font-family: Arial, sans-serif; line-height: 1.3em; color: #232323;">
										<tbody>
											<tr style="font-family: Arial, sans-serif; line-height: 1.3em;">
												<td align="center" class="footer_container_inner bottom-nav" style="line-height: 1.3em; font-family: Arial,sans-serif; font-size: 12px; color: #646464;">
													<table border="0" cellpadding="0" cellspacing="0" width="auto" class="top_nav" style="font-family: Arial, sans-serif; line-height: 1.3em; color: #232323;">
													<tbody>
														<tr style="font-family: Arial, sans-serif; line-height: 1.3em;">
															<td class="nav-text-block " style="font-family: Arial, sans-serif; line-height: 1.3em; height: 18px; font-size: 11px; padding: 2px 6px;"> <a href="https://www.gineicomarine.com.au/products/" style="color: #232323; font-style: none; text-decoration: none;"> Products </a> </td>
															<td class="nav-text-block " style="font-family: Arial, sans-serif; line-height: 1.3em; height: 18px; font-size: 11px; padding: 2px 6px;"> <a href="https://www.gineicomarine.com.au/my-account" style="color: #232323; font-style: none; text-decoration: none;"> My Account </a> </td>
															<td class="nav-text-block " style="font-family: Arial, sans-serif; line-height: 1.3em; height: 18px; font-size: 11px; padding: 2px 6px;"> <a href="https://www.gineicomarine.com.au/contact-us/" style="color: #232323; font-style: none; text-decoration: none;"> Contact Us </a> </td>
														</tr>
													</tbody>
													</table>
													<table border="0" cellpadding="0" cellspacing="0" width="auto" class="top_nav" style="font-family: Arial, sans-serif; line-height: 1.3em; color: #232323;">
														<tbody>
														<tr style="font-family: Arial, sans-serif; line-height: 1.3em;">
															<td class="nav-image-block" style="text-align: center; padding: 8px 12px;">
																<a href="https://www.facebook.com/gineicomarine/" style="font-style: none; text-decoration: none;" target="_blank"> <img width="20" height="20" style="margin-right: 0;" src="<?php echo site_url(); ?>/wp-content/themes/bridge-child/images/social-thumb-facebook.png" title="Facebook"> </a> 
															</td>
															<td class="nav-image-block" style="text-align: center; padding: 8px 12px;">
																<a href="https://www.instagram.com/gineico_marine/" style="font-style: none; text-decoration: none;" target="_blank"> <img width="20" height="20" style="margin-right: 0;" src="<?php echo site_url(); ?>/wp-content/themes/bridge-child/images/social-thumb-instagram.png" title="Instagram"> </a> 
															</td>
															<td class="nav-image-block" style="text-align: center; padding: 8px 12px;">
																<a href="https://www.youtube.com/channel/UCoGkOukwxPVN0ENO_7ly4uA/" style="font-style: none; text-decoration: none;" target="_blank"> <img width="20" height="20" style="margin-right: 0;" src="<?php echo site_url(); ?>/wp-content/themes/bridge-child/images/social-thumb-youtube.png" title="YouTube"> </a> 
															</td>
															<td class="nav-image-block" style="text-align: center; padding: 8px 12px;">
																<a href="https://www.linkedin.com/company/gineico-marine/" style="font-style: none; text-decoration: none;" target="_blank"> <img width="20" height="20" style="margin-right: 0;" src="<?php echo site_url(); ?>/wp-content/themes/bridge-child/images/social-thumb-linkedin.png" title="LinkedIn"> </a> 
															</td>
														</tr>
													</tbody>
													</table>
												</td>
											</tr>
										</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
						<!-- End Footer -->
					</td>
				</tr>
						</table>
					</td>
				</tr>
				
			</table>
		</div>
	</body>
</html>
