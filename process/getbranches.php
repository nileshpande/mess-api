<label>Branch</label>
<select class="selectpicker   btn-block"  title="Select Branch" name="branch" required="true" aria-required="true" style="display: inline !important;border-radius: 20px;
    box-sizing: border-box;
    border-width: 2px;
    background-color: transparent;
    font-size: 14px;
    font-weight: 600;
    padding: 7px 18px;border-color: #ff5722;" >
<?php
if($_POST['id']=="science")
{
?>
<option value="B.TECH">B.TECH</option>
<option value="B.PHARM">B.PHARM</option>
<option value="M.PHARM">M.PHARM</option>
<option value="M.TECH(COSMETIC)">M.TECH(COSMETIC)</option>
<option value="BE">BE</option>
<option value="ME">ME</option>
<option value="B.Sc">B.Sc</option>
<option value="M.TECH(ENGINEERING)">M.TECH(ENGINEERING)</option>
<option value="PHD">PHD</option>
<option value="BCA">BCA</option>
<option value="M.Sc">M.Sc</option>
<option value="MCA">MCA</option>
<option value="Diploma Agriculture">Diploma Agriculture</option>
<option value="Diploma Animation">Diploma Animation</option>
<option value="Diploma Engineering">Diploma Engineering</option>
<?php
}

if($_POST['id']=="comerce")
{
?>
<option value="BA">BA</option>
<option value="LLB">LLB</option>
<option value="BSW">BSW</option>
<option value="B.com">B.com</option>
<option value="MA">MA</option>
<option value="MA">MSW</option>
<option value="MA">MA</option>
<option value="MA">MA</option>

<?php
}
if($_POST['id']=="arts")
{
?>
<option value="BA">MA</option>
<?php
}	
?>

</select>