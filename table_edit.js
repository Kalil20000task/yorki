function initializeTableEdit(modalId, editButtonClass, fetchUrl, updateUrl) {
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(`.${editButtonClass}`).forEach((button) => {
            button.addEventListener("click", () => {
                const rowId = button.getAttribute("data-id");
                const tableName = button.getAttribute("data-table");

                // Fetch data via AJAX
                fetch(`${fetchUrl}?id=${rowId}&table=${tableName}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Error: ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        const dynamicFields = document.querySelector(`#${modalId} #dynamicFields`);
                        dynamicFields.innerHTML = ""; // Clear old fields

                        // Generate form fields dynamically
                        for (const [key, value] of Object.entries(data)) {
                            dynamicFields.innerHTML += `
                                <div class="form-group">
                                    <label>${key}</label>
                                    <input type="text" class="form-control" name="${key}" value="${value}">
                                </div>
                            `;
                        }

                        // Show the modal
                        const modal = new bootstrap.Modal(document.getElementById(modalId));
                        modal.show();
                    })
                    .catch(error => {
                        console.error("Fetch Error:", error); // Log error
                        alert("An error occurred while fetching the data.");
                    });
            });
        });

        // Save changes on button click
        document.querySelector(`#${modalId} #saveChanges`).addEventListener("click", () => {
            const formData = new FormData(document.querySelector(`#${modalId} #editForm`));

            fetch(updateUrl, {
                method: "POST",
                body: formData,
            })
            
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(result => {
                    if (result.success) {
                        alert("Row updated successfully!");
                        location.reload();
                    } else {
                        alert("Error updating row!");
                    }
                })
                .catch(error => {
                    console.error("Update Error:", error); // Log error
                    alert("An error occurred while updating the row.");
                });
        });
    });
}
