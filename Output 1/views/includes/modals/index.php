<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Record</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form id="frmEdit">
            <div class="card">
                <div class="card-header">
                    Student's Information
                </div>

                <div class="card-body">
            
                    <div class="mb-3 mt-3">
                        <label for="fname" class="form-label">First Name:</label>
                        <input type="hidden" id="id" name="id">
                        <input type="text" class="form-control" id="fname" placeholder="Enter First Name" name="fname" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="mname" class="form-label">Middle Name:</label>
                        <input type="text" class="form-control" id="mname" placeholder="Enter Middle Name" name="mname" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="lname" class="form-label">Last Name:</label>
                        <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="lname" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="gender" class="form-label">Gender:</label>
                        <select class="form-select" name="gender" id="gender">
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>

      </div>
    </div>
  </div>
</div>