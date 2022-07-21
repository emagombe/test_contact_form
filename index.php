<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Contact Form</title>
</head>
<body>
	<div style="height: 100vh; flex: 1; display: flex; flex-direction: row; align-items: center; justify-content: center; flex-wrap: wrap;">
		<form method="post" style="border: 2px solid black; padding: 10px; max-width: 400px;">
			<div style="min-width: 240px; margin: 10px;">
				<label for="name">Name: <span style="color: red;">*</span></label>
				<input id="name" type="text" name="name" style="width: 100%;" maxlength="120" required minlength="3">
			</div>
			<div style="min-width: 240px; margin: 10px;">
				<label for="email">E-mail: <span style="color: red;">*</span></label>
				<input id="email" type="email" name="email" style="width: 100%;" maxlength="320" required minlength="5">
			</div>
			<div style="min-width: 240px; margin: 10px;">
				<label for="message">Message: <span style="color: red;">*</span></label>
				<textarea id="message" name="message" style="width: 100%; min-height: 100px;" maxlength="500" required minlength="10"></textarea>
			</div>
			<div>
				<button
					style="min-width: 240px; margin: 10px;"
					type="submit"
				>
					Submit
				</button>
			</div>
		</form>

		<div style="margin: 50px; height: 80%; border: 2px solid black; overflow-y: scroll; min-width: 300px; padding: 5px">
			<table width="100%">
				<thead>
					<th>ID</th>
					<th>Name</th>
					<th>E-mail</th>
					<th>Message</th>
					<th>Date Added</th>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<script type="text/javascript">
		(function() {
			var base_url = window.location.href;

			var table = document.querySelector("table");
			var button_submit = document.querySelector("table");
			var table_body = document.querySelector("table tbody");

			var name = "";
			var email = "";
			var message = "";

			var update_table = async function() {
				var response = await fetch(base_url + "actions/list.php", {
					method: "post",
				});
				var response_data = await response.json();

				if(Array.isArray(response_data)) {
					let html = "";
					for(let item of response_data) {
						if(typeof item.id !== "undefined") {
							html += "<tr>";
							html += "<td>";
							html += item.id;
							html += "</td>";
							html += "<td>";
							html += item.name;
							html += "</td>";
							html += "<td>";
							html += item.email;
							html += "</td>";
							html += "<td>";
							html += item.message;
							html += "</td>";
							html += "<td>";
							html += item.date_added;
							html += "</td>";
							html += "</tr>";
						}
					}
					table_body.innerHTML = html;
				}
			};
			update_table();
			var form = document.querySelector("form");
			form.addEventListener("submit", async function(event) {
				event.preventDefault();

				try {
					name = document.querySelector("#name").value;
					email = document.querySelector("#email").value;
					message = document.querySelector("#message").value;

					var form_data = new FormData();

					form_data.append("name", name);
					form_data.append("email", email);
					form_data.append("message", message);

					button_submit.setAttribute("disabled", true);
					var response = await fetch(base_url + "actions/add.php", {
						method: "post",
						body: form_data,
					});
					var response_data = await response.json();

					if(typeof response_data.status !== "undefined") {
						if(response_data.status == "success") {
							form.reset();
							update_table();
							alert(response_data.message);
						} else {
							alert(response_data.message);
						}
					} else {
						alert(response_data);
					}
					button_submit.removeAttribute("disabled", false);
				} catch(ex) {
					console.log(ex);
					alert("An error occurred while trying to submit the information");
				}
			});

		})();
	</script>
</body>
</html>