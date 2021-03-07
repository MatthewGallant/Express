
function editModal(id, color) {

    var html = `
        <div class="modal fade" id="` + id + `_edit" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="` + id + `_edit">Edit Modifier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure that you want to edit this modifier list? This change will be made to every item using this modifier list.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="edit-modifier-list.php?id=` + id + `&return=edit_item" class="btn btn-` + color + `">Edit Modifier List</a>
                </div>
                </div>
            </div>
        </div>
    `;

    $(document.getElementById("modalDiv")).append(html);
    $(document.getElementById(id + "_edit")).modal('show');
    
}

function deleteModal(item_id, modifier_id) {

    var html = `
        <div class="modal fade" id="` + modifier_id + `_delete" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="` + modifier_id + `_delete">Remove Modifier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure that you want to remove this modifier list? This will only remove the modifier list from this item.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="delete-modifier.php?item=` + item_id + `&modifier=` + modifier_id + `" class="btn btn-danger">Remove Modifier List</a>
                </div>
                </div>
            </div>
        </div>
    `;

    $(document.getElementById("modalDiv")).append(html);
    $(document.getElementById(modifier_id + "_delete")).modal('show');
    
}

function deleteItem(item_id) {

    var html = `
        <div class="modal fade" id="` + item_id + `_delete" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="` + item_id + `_delete">Delete Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure that you want to delete this item? This will permanently remove the item from your menu.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="delete-item.php?id=` + item_id + `" class="btn btn-danger">Delete Item</a>
                </div>
                </div>
            </div>
        </div>
    `;

    $(document.getElementById("modalDiv")).append(html);
    $(document.getElementById(item_id + "_delete")).modal('show');
    
}

function deleteCategory(category_id) {

    var html = `
        <div class="modal fade" id="` + category_id + `_delete" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="` + category_id + `_delete">Delete Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure that you want to delete this category? This will permanently remove the item from your menu.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="delete-category.php?id=` + category_id + `" class="btn btn-danger">Delete Category</a>
                </div>
                </div>
            </div>
        </div>
    `;

    $(document.getElementById("modalDiv")).append(html);
    $(document.getElementById(category_id + "_delete")).modal('show');
    
}

function deleteAccount(account_id) {

    var html = `
        <div class="modal fade" id="` + account_id + `_delete" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="` + account_id + `_delete">Delete Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure that you want to delete this account? This will permanently remove the account.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="delete-account.php?id=` + account_id + `" class="btn btn-danger">Delete Account</a>
                </div>
                </div>
            </div>
        </div>
    `;

    $(document.getElementById("modalDiv")).append(html);
    $(document.getElementById(account_id + "_delete")).modal('show');
    
}

function deleteManager(account_id) {

    var html = `
        <div class="modal fade" id="` + account_id + `_delete" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="` + account_id + `_delete">Delete Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure that you want to delete this account? This will permanently remove the account.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="delete-manager.php?id=` + account_id + `" class="btn btn-danger">Delete Account</a>
                </div>
                </div>
            </div>
        </div>
    `;

    $(document.getElementById("modalDiv")).append(html);
    $(document.getElementById(account_id + "_delete")).modal('show');
    
}

function deleteList(list_id) {

    var html = `
        <div class="modal fade" id="` + list_id + `_delete" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="` + list_id + `_delete">Delete List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure that you want to delete this modifier list? This will permanently remove it from the store.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="delete-list.php?id=` + list_id + `" class="btn btn-danger">Delete List</a>
                </div>
                </div>
            </div>
        </div>
    `;

    $(document.getElementById("modalDiv")).append(html);
    $(document.getElementById(list_id + "_delete")).modal('show');
    
}

function deleteOption(modifier_id, option_id) {

    var html = `
        <div class="modal fade" id="` + option_id + `_delete" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="` + option_id + `_delete">Delete Option</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure that you want to delete this option? This will permanently remove it from the modifier.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="delete-option.php?id=` + modifier_id + `&option=` + option_id + `" class="btn btn-danger">Delete Option</a>
                </div>
                </div>
            </div>
        </div>
    `;

    $(document.getElementById("modalDiv")).append(html);
    $(document.getElementById(option_id + "_delete")).modal('show');
    
}

function finalizeOrder(order_id) {

    var html = `
        <div class="modal fade" id="` + order_id + `_delete" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="` + order_id + `_delete">Finalize Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure that you want to finalize this order? It will be recorded as complete.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="finalize-order.php?id=` + order_id + `" class="btn btn-danger">Finalize Order</a>
                </div>
                </div>
            </div>
        </div>
    `;

    $(document.getElementById("modalDiv")).append(html);
    $(document.getElementById(order_id + "_delete")).modal('show');
    
}
