<div id="content-wrap" class="right">
	<div id="content-body">
   <h2>Please Input your new password</h2>
<form name="frmuser" method="post" action="<?php echo $form_action; ?>">
	<input type="hidden" name="custid" value="<?php echo set_value('custid', isset($default['custid']) ? $default['custid'] : ''); ?>" />
    <table class="cust-profile">
        <tr>
            <td class="label-field">Current Password :</td>
            <td class="content-field"><input type="password" name="curr-pass" size="15" value="<?php echo set_value('password', isset($default['password']) ? $default['password'] : ''); ?>" readonly="readonly" /></td>
        </tr>
        <tr>
            <td class="label-field">New Password :</td>
            <td class="content-field"><input type="password" name="new-pass" size="15" value="" /></td>
        </tr>
        <tr>
            <td class="label-field">Confirm Password :</td>
            <td class="content-field"><input type="password" name="confirm-pass" size="15" value="" /></td>
        </tr>
    </table>
    <input type="submit" name="submit-pass" value="Save" />
</form>
	<h2><?php echo $err_msg; ?></h2>
	</div>	
</div>
			<div class="clear"></div>
		</div>
	</div>
</div>