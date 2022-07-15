<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login to iDisuss</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action ="/forum/partials/_handellogin.php" method="post">
            <div class="modal-body">
                    <div class="mb-3">
                        <label for="loginemail" class="form-label">User Name </label>
                        <input type="text" class="form-control" id="loginemail" name="loginemail" aria-describedby="emailHelp">
                        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                    </div>
                    <div class="mb-3">
                        <label for="loginpass" class="form-label">Password</label>
                        <input type="password" class="form-control" id="loginpass" name="loginpass">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>