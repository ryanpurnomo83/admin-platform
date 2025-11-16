<div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <span class="count-total-list float-end mt-2">0 Data</span>
                        </div>
                        <a class="btn btn-secondary float-end text-white mx-1" data-bs-toggle="offcanvas">
                            Create
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8 col-md-6"></div>
                            <div class="col-4 col-md-6"></div>
                            <div class="col-md-12">
                                <form id="form-filter-list" action="#" method="get">
                                    <?php
                                    
                                    dd($transactions);
                                    
                                    ?>
                                    <div class="row my-3">
                                        <div class="col-md-2">
                                            <small>Search</small>
                                            <div class="form-group">
                                                <input class="form-control search-list" name="search" placeholder="Type for search...">
                                                <input type="hidden" name="route_name" value="transactions">
                                                <input type="hidden" name="page">
                                                <input type="hidden" name="order">
                                                <input type="hidden" name="manydatas" value="10">
                                                <input type="hidden" name="order_state" value="ASC">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table id="table-list" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="white-space: nowrap;">No
                                            <button class="btn btn-sm btn-link"><i class="ti ti-arrow-up"></i></button>
                                        </th>
                                        <th style="white-space: nowrap;">Created at
                                            <button class="btn btn-sm btn-link"><i class="ti ti-arrow-up"></i></button>
                                        </th>
                                        <th style="white-space: nowrap;">Updated at
                                            <button class="btn btn-sm btn-link"><i class="ti ti-arrow-up"></i></button>
                                        </th>
                                        <th class="col-action"></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-1 col-lg-1 col-2">
                                    <select class="form-control form-control-sm" id="manydatas-show">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="All">All</option>
                                    </select>
                                </div>
                                <div class="col-md-11">
                                    <div id="paginate-list"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
</div>

<div class="pc-container" id="section-preview" style="display:none;">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                           <b>Detail Transactions</b> 
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger float-end close-preview">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 content-preview"></div>
        </div>
    </div>
</div>

<!-- Offcanvas Create Form -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="createForm" aria-labelledby="createForm">
    <div class="offcanvas-header border-bottom bg-secondary p-4">
        <h5 class="text-white m-0">Create New</h5>
        <button type="button" class="btn-close text-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="form-create" action="#" method="post">
            <div class="row">
                <!-- form fields placeholder -->
                <div class="col-md-12">
                    <div class="form-group my-2">
                        <button id="btn-for-form-create" type="button" class="btn btn-outline-secondary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
