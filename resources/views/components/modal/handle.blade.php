<div class="modal" id="modal-handle">
    <div class="modal-dialog" style="min-width:60%">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 id="header-modal-handle" class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" action="" id="formHandle">
                    @csrf
                    @method('put')
                    @yield('bodyModalHandle')
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-secondary border">Hủy</button>
                <button id="accept-handle-btn" type="button" class="btn btn-primary">Cập nhật</button>
            </div>
        </div>
    </div>
</div>
<script>
    const headerModalHandle = document.getElementById('header-modal-handle');
    const formHandle = document.getElementById('formHandle');
    const btnAcceptHandle = document.getElementById('accept-handle-btn');

    formHandle.addEventListener('submit', event => {
        event.preventDefault();
        btnAcceptHandle.click();
    });

    // submit form
    btnAcceptHandle.addEventListener('click', async (e) => {
        e.preventDefault();
        const response = await fetch(formHandle.action, {
            body: new FormData(formHandle),
            method: 'post'
        });

        const {
            status_code,
            data
        } = await response.json();

        // handle error
        if (status_code === 200 || data['isRedirect']) {
            window.location.reload();
        }
        if (status_code != 200) {
            for (element of formHandle.elements) {
                if (['_method', '_token'].includes(element.name)) {
                    continue;
                }
                if (Object.keys(data).includes(element.name)) {
                    element.setAttribute('class', 'form-control is-invalid')
                    if (!element.nextElementSibling) {
                        element.parentElement.innerHTML += `
                            <div class="invalid-feedback">
                            ${data[element.name].join(" - ")}
                            </div>`
                    } else {
                        element.nextElementSibling.innerHTML = `${data[element.name].join(" - ")}`
                    }
                } else {
                    resetValidForm(element);
                }
            }
        }
    })

    const resetValidForm = (element) => {
        element.setAttribute('class', 'form-control')
        if (element.nextElementSibling)
            element.nextElementSibling.remove();
    }

    /**@argument
     * Set modal delete in list page
     */
    const setModalHandle = (namePage, actionUrl = location.pathname) => {
        const btnAdd = document.getElementById('btn-modal-add');
        const btnEdits = document.querySelectorAll('.btn-modal-edit');
        // // open modal add
        if (btnAdd) {
            btnAdd.addEventListener('click', (e) => {
                for (element of formHandle.elements) {
                    if (!['_method', '_token'].includes(element.name)) {
                        if (element.type === 'file') {
                            document.getElementById('avatar-image').setAttribute('src',
                                `${location.protocol}//${location.host}/assets/images/placeholder-images.png`
                            );
                        }
                        element.value = '';
                        resetValidForm(element);
                    }
                }
                headerModalHandle.innerHTML = `Thêm ${namePage}`;
                btnAcceptHandle.innerHTML = 'Thêm';
                formHandle.action = `${actionUrl}`
                formHandle['_method'].value = 'POST'
            })
        }

        // open modal edit
        btnEdits.forEach(btn => btn.addEventListener('click', (e) => {
            let {
                data
            } = e.target.dataset;
            console.log(data);
            data = JSON.parse(data)
            for (element of formHandle.elements) {
                if (!['_method', '_token'].includes(element.name)) {
                    switch (element.type) {
                        case 'file':
                            document.getElementById('avatar-image').setAttribute('src',
                                `${location.protocol}//${location.host}/${data[element.name]}`);
                            break;
                        case 'select-one':
                            [...element.options].forEach(option => option.setAttribute('style',
                                'display: block'));
                            const indexOptionOfCurrentCategory = [...element.options].findIndex(i => i
                                .value == data.id);
                            if (indexOptionOfCurrentCategory > -1) {
                                element.options[indexOptionOfCurrentCategory].setAttribute('style',
                                    'display: none');
                            }
                            const indexOfOption = [...element.options].findIndex(i => i.value == (data[
                                element.name] ? data[element.name] : ''));
                            if (indexOfOption > -1) {
                                element.options.selectedIndex = indexOfOption;
                            }
                            break;
                        default:
                            element.value = data[element.name];
                    }
                    resetValidForm(element);
                }
            }

            headerModalHandle.innerHTML = `Sửa ${namePage}`;
            btnAcceptHandle.innerHTML = 'Cập nhật';
            formHandle.action = `${actionUrl}/${data.id}`
            formHandle['_method'].value = 'PUT'
        }))
    }
</script>
