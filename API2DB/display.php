<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
  <title>Read a JSON File</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<style>
#tbstyle {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 50%;
}

#tbstyle td, #tbstyle th {
  border: 1px solid #ddd;
  padding: 8px;
}

#tbstyle tr:nth-child(even){background-color: #f2f2f2;}

#tbstyle tr:hover {background-color: #ddd;}

#tbstyle th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #859161;
  color: White;
}
</style>
      </head>
	  <body>
	   <div class="container" style="width:500px;">
	   <div class="table-container">
	   <?php
			 if(isset($message))
			 {
				  echo $message;

			 ?>
		<table id="tbstyle">
			<tbody>
				<tr>
					<th>Employee Code</th>
					<th>Department Name</th>
					<th>Company</th>
					<th>First Name</th>
					<th>Middle Name</th>
                    <th>Last Name</th>
				</tr>
				<?php foreach ($users as $user) { ?>
				<tr>
					<td> <?= $user->Region; ?> </td>
					<td> <?= $user->DepartmentName; ?> </td>
					<td> <?= $user->COMPANY_Name; ?> </td>
					<td> <?= $user->FirstName; ?> </td>
					<td> <?= $user->MiddleName; ?> </td>
                    <td> <?= $user->LastName; ?> </td>
				</tr>
				<?php }
			 }
			 else
				echo $message;
			 ?>
    </tbody>
</table>
</div>
</div>
</body>
</html>