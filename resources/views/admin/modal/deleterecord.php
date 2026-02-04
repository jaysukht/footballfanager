<!-- View Request Estimates Modal -->
<div class="modal fade cls-request-wraper" id="deleteRecordModal" tabindex="-1" aria-labelledby="DeleteRecordLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRecordLabel">Are you sure?</h5>
            </div>
            <div class="modal-body" id="deleteRecordModalBody">
                <div class="form-section new-modal-form">
                    <div class="input-group full-width">
                        <p>Once deleted, you will not be able to recover this record!</p>
                    </div>
                    <div class="for-cls-approval ft-btn-flex">
                        <div class="ft-form-btn">

                            <div class="input-group">
                                <button type="button" class="btn btn-primary delete-record">Delete Record<svg
                                        class="loader-ajax d-none" width="40" height="40" viewBox="0 0 50 50">
                                        <circle cx="25" cy="25" r="20" fill="none" stroke="#fff"
                                            stroke-width="4" stroke-linecap="round" stroke-dasharray="100"
                                            stroke-dashoffset="75">
                                            <animateTransform attributeName="transform" type="rotate"
                                                repeatCount="indefinite" dur="1s" from="0 25 25" to="360 25 25" />
                                        </circle>
                                    </svg></button>
                            </div>

                            <div class="input-group">
                                <button type="button" class="btn btn-primary cancel-record" data-bs-dismiss="modal"
                                    aria-label="Close">Cancel</button>
                            </div>
                        </div>
                        <input type="hidden" class="delete-record-id" id="delete-id">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>