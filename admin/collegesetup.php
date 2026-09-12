<?php
include "header.php";
?>
<main>
        </nav>

        <div class="container-fluid mb-5">

            <form class="needs-validation" novalidate>

                <!-- Logo Preview Header -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="row align-items-center g-4">
                            <div class="col-auto">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center border border-3 border-primary">
                                    <i class="bi bi-bank2 display-1 text-primary p-2"></i>
                                </div>
                            </div>
                            <div class="col-md">
                                <h3 class="mb-1">Ganga Institute of Technology &amp; Management</h3>
                                <p class="text-body-secondary mb-2">
                                    <i class="bi bi-geo-alt-fill me-1"></i>Sri Ganganagar, Rajasthan
                                </p>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge text-bg-secondary"><i class="bi bi-mortarboard-fill me-1"></i>Affiliated Institute</span>
                                    <span class="badge text-bg-success"><i class="bi bi-check-circle me-1"></i>Active</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-outline-primary"><i class="bi bi-upload me-1"></i>Change Logo</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Basic Details -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary bg-gradient text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-bank2 me-2"></i>Basic Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="collegeName" class="form-label">College Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-bank2"></i></span>
                                    <input type="text" class="form-control" id="collegeName" value="Ganga Institute of Technology &amp; Management" required>
                                    <div class="invalid-feedback">College name is required.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="logoUpload" class="form-label">Logo</label>
                                <input type="file" class="form-control" id="logoUpload" accept="image/*">
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                    <textarea class="form-control" id="address" rows="2">NH-62, Near Ganganagar Bypass, Sri Ganganagar, Rajasthan &ndash; 335001</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary bg-gradient text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-telephone-fill me-2"></i>Contact Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                    <input type="tel" class="form-control" id="phone" value="+91 154-2XXXXXX" required>
                                    <div class="invalid-feedback">Phone number is required.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" class="form-control" id="email" value="info@gitm.edu.in" required>
                                    <div class="invalid-feedback">A valid email is required.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="website" class="form-label">Website</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-globe2"></i></span>
                                    <input type="url" class="form-control" id="website" value="https://www.gitm.edu.in">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Affiliation Details -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary bg-gradient text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-award-fill me-2"></i>Affiliation Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="university" class="form-label">University</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-mortarboard-fill"></i></span>
                                    <input type="text" class="form-control" id="university" value="Maharaja Ganga Singh University">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="affiliation" class="form-label">Affiliation</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-patch-check-fill"></i></span>
                                    <input type="text" class="form-control" id="affiliation" value="AICTE Approved &amp; UGC Recognized">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Leadership -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary bg-gradient text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-person-badge-fill me-2"></i>Leadership</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="principal" class="form-label">Principal</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                                    <input type="text" class="form-control" id="principal" value="Dr. R. K. Sharma">
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <div class="alert alert-light border w-100 mb-0 py-2 small">
                                    <i class="bi bi-info-circle me-1"></i>Displayed on ID cards, certificates, and official letterheads.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4 d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check2-circle me-1"></i>Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>

</main>
<?php
include "footer.php";
?>