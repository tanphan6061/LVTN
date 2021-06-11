<div class="modal" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 id="header-modal-delete" class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <h2 id="message-modal-delete"></h2>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-secondary border">Hủy</button>
                <button onclick="document.getElementById('delete-form').submit()" id="accept-delete-btn" type="button"
                    class="btn btn-danger">Xóa</button>
                <form method="post" id="delete-form" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const setModalDelete = (type, message) => {
        switch (type) {
            case 'header':
                document.getElementById('header-modal-delete').innerHTML = `Xoá ${message}`;
                break;
            case 'body':
                document.getElementById('message-modal-delete').innerHTML = `Bạn muốn xóa ${message}?`;
                break;
            case 'action':
                document.getElementById('delete-form').setAttribute('action', message);
                break;
        }
    }
    // const messDelete = document.getElementById('mess-delete');
    // messDelete.innerHTML = `Bạn muốn xóa sản phẩm: ${nameproduct}?`;
    // const deleteForm = document.getElementById('delete-form');
    // deleteForm.setAttribute('action', `${location.pathname}/${id}`)

    /**@argument
     * Set modal delete in list page
     */
    const setModalDeleteInListPage = (namePage) => {
        setModalDelete('header', namePage)
        const btns = document.querySelectorAll('.btn-modal-delete');
        btns.forEach(btn => btn.addEventListener('click', (e) => {
            const {
                name,
                id
            } = e.target.dataset;

            setModalDelete('body', `${namePage} ${name}`)
            setModalDelete('action', `${location.pathname}/${id}`)
        }))
    }
</script>
