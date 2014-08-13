<?php echo "$header"; ?>
<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<?php if ($error_warning) { ?>
	<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
	<div class="box">
		<div class="heading">
			<h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
			<div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
		</div>
		<div class="content">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<table class="form">
					<tr>
						<td><span class="required">*</span> <?php echo $text_domain_id; ?></td>
						<td>
							<input type="text" size="80" name="minewhat_domain_id" value="<?php echo $minewhat_domain_id; ?>"/>
						</td>
					</tr>
					<tr>
						<td><span class="required">*</span> <?php echo $text_enable; ?></td>
						<td><select name="minewhat_enable">
							<?php if ($minewhat_enable) { ?>
								<option value="1" selected="selected"><?php echo $option_enable; ?></option>
								<option value="0"><?php echo $option_disable; ?></option>
							<?php } else { ?>
								<option value="1"><?php echo $option_enable; ?></option>
								<option value="0" selected="selected"><?php echo $option_disable; ?></option>
							<?php } ?>
						</select></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
<?php echo $footer; ?>
