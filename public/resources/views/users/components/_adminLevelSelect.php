<?php

$userId = objParamExistsOrDefault($data, 'user_id');

$isAdminUser = $_SESSION['adm_id'] == 1;

if (!$isAdminUser) return;

if ($userId == 1) echo '<input type="hidden" name="adm" value="1">';

$usersEditPage = !empty($dataPage) && $dataPage == 'users/edit';

$typeLevels = [0 => 'Comum', 1 => 'Administrador'];

$adminId = objParamExistsOrDefault($data, 'adm');

?>
<div class="form-group">
  <label for="adm">Nível administrativo</label>

  <select name="adm" id="adm">
    <optgroup label="Tipo de usuário">
      <?php foreach ($typeLevels as $key => $value) :

        $selected = ($key == 0) ? 'selected' : '';
        
        $selected =
        $adminId && ($key == $adminId) ? 'selected' : $selected;

        echo "<option value='$key' $selected>$value</option>";
      endforeach;

      ?>
    </optgroup>
  </select>
</div>