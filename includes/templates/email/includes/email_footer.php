<?php 
	$inhalt .= '
					<table bgcolor="#F8F9FA" border="0" cellpadding="0" cellspacing="0" width="500">
						<tr>
							<td align="center" valign="top">
								<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#F8F9FA">
									<tr>
										<td align="center" valign="top">
											<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
												<tr>
													<td align="center" valign="top" width="500" class="flexibleContainerCell">
														<table border="0" cellpadding="30" cellspacing="0" width="100%">
															<tr>
																<td align="center" valign="top" bgcolor="#F8F9FA">
																	<table border="0" cellpadding="0" cellspacing="0" width="100%">
																		<tr>
																			<td valign="top" class="textContent">
																				<div style="text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">'.$this->inhalt->textarea_value_to_html($einstellungen['allgemeine_email_signatur']).'</strong></div>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					
					<table bgcolor="#E1E1E1" border="0" cellpadding="0" cellspacing="0" width="500" id="emailFooter">
							<tr>
								<td align="center" valign="top">

									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td align="center" valign="top">

												<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
													<tr>
														<td align="center" valign="top" width="500" class="flexibleContainerCell">
															<table border="0" cellpadding="30" cellspacing="0" width="100%">
																<tr>
																	<td valign="top" bgcolor="#E1E1E1">

																		<div style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#828282;text-align:center;line-height:120%;">
																			<div>Copyright &#169; '.date("Y").' <a href="'.$config['httpsurl'].'" target="_blank" style="text-decoration:none;color:#828282;"><span style="color:#828282;">'.$config['system_name'].'</span></a>. All&nbsp;rights&nbsp;reserved.</div>
																		</div>

																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>

											</td>
										</tr>
									</table>

								</td>
							</tr>

						</table>
					</td>
				</tr>
			</table>
		</center>
	</body>
</html>';