<?php

// Query to get contact data
$sql = "SELECT * FROM contacts";
$result = $conn->query($sql);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Contact Management</h5>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["subject"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["message"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                                echo "<td>";
                                echo "<button style='margin-right: 10px; type='button' class='btn btn-primary' onclick='viewContact(" . $row["contact_id"] . ")'>View</button>";
                                echo "<button type='button' class='btn btn-danger' onclick='deleteContact(" . $row["contact_id"] . ")'>Delete</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Viewing Contact -->
<div class="modal fade" id="viewContactModal" tabindex="-1" aria-labelledby="viewContactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewContactModalLabel">Contact Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="contactDetailsContainer"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Deleting Contact -->
<div class="modal fade" id="deleteContactModal" tabindex="-1" aria-labelledby="deleteContactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteContactModalLabel">Delete Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this contact?</p>
                <form id="deleteContactForm">
                    <input type="hidden" id="deleteContactId" name="contactId">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function viewContact(contactId) {
        fetch(`../backEnd/get_contact.php?id=${contactId}`)
            .then(response => response.json())
            .then(data => {
                let contactHtml = `<p><strong>Name:</strong> ${data.name}</p>
                                   <p><strong>Subject:</strong> ${data.subject}</p>
                                   <p><strong>Email:</strong> ${data.email}</p>
                                   <p><strong>Phone:</strong> ${data.phone}</p>
                                   <p><strong>Message:</strong> ${data.message}</p>
                                   <p><strong>Date:</strong> ${data.created_at}</p>`;
                document.getElementById("contactDetailsContainer").innerHTML = contactHtml;
                var modal = new bootstrap.Modal(document.getElementById('viewContactModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to fetch contact details.');
            });
    }

    function deleteContact(contactId) {
        document.getElementById("deleteContactId").value = contactId;
        var modal = new bootstrap.Modal(document.getElementById('deleteContactModal'));
        modal.show();
    }

    document.getElementById("deleteContactForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch('../backEnd/delete_contact.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('deleteContactModal'));
                    modal.hide();
                    location.reload();
                } else {
                    alert('Failed to delete contact.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete contact.');
            });
    });
</script>
