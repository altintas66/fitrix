<?php
include 'includes/email_header.php';
$inhalt .= '
<table bgcolor="#FFFFFF"  border="0" cellpadding="0" cellspacing="0" width="500" id="emailBody">
	<tr>
		<td align="center" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;" bgcolor="'.$config['primary_color'].'">
				<tr>
					<td align="center" valign="top">
						<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
							<tr>
								<td align="center" valign="top" width="500" class="flexibleContainerCell">
									<table border="0" cellpadding="30" cellspacing="0" width="100%">
										<tr>
											<td align="center" valign="top" class="textContent">
												<h1 style="color:#FFFFFF;line-height:100%;font-family:Helvetica,Arial,sans-serif;font-size:35px;font-weight:normal;margin-bottom:5px;text-align:center;">'.$headline.'</h1>
												<h2 style="text-align:center;font-weight:normal;font-family:Helvetica,Arial,sans-serif;font-size:23px;margin-bottom:10px;color:#fff;line-height:135%;">'.$subline.'</h2>
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
	<tr>
		<td align="center" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#F8F8F8">
				<tr>
					<td align="center" valign="top">
						<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
							<tr>
								<td align="center" valign="top" width="500" class="flexibleContainerCell">
									<table border="0" cellpadding="30" cellspacing="0" width="100%">
										<tr>
											<td align="center" valign="top">
												<table border="0" cellpadding="0" cellspacing="0" width="100%">
													<tr>
														<td valign="top" class="textContent">
															'.$email_inhalt.'
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
</table>';
include 'includes/email_footer.php';
?>
