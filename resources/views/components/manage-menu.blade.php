<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@php
  $menus = \App\Models\Menu::whereNull(['menu_id', 'parent_id'])
      ->orderBy('list')
      ->with('subMenus.subSubMenus')
      ->get();
@endphp
<div id="chooseMenuTypeModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Choose Type of Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p>Please choose type of menu:</p>
        <button class="btn btn-primary w-100 mb-2" onclick="openMenuForm('menu')">Main Menu</button>
        <button class="btn btn-secondary w-100" onclick="openMenuForm('submenu')">Sub Menu</button>
      </div>
    </div>
  </div>
</div>

<div id="menuFormModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="menuFormTitle">Create Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/menus/store" method="post">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="type" id="menuTypeInput">
          <div class="mb-3 d-none" id="parentMenuContainer">
            <label class="form-label d-block">Choose Main Menu (Fill in either the Menu ID or Parent
              ID)</label>
            <small>Fill Menu ID if it's a sub menu</small>
            <select name="menu_id" id="menuSelect" class="form-select">
              <option value="">Select Menu ID</option>
              @foreach ($menus as $menu)
                <option value="{{ $menu->id }}">{{ $menu->name }}</option>
              @endforeach
            </select>
            <small>Fill Parent ID if it's a sub-sub menu</small>
            <select name="parent_id" id="parentSelect" class="form-select">
              <option value="">Select Parent ID</option>
              @foreach ($menus as $menu)
                @foreach ($menu->subMenus as $submenu)
                  <option value="{{ $submenu->id }}">{{ $submenu->name }}</option>
                @endforeach
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Menu Name</label>
            <input type="text" name="name" class="form-control" required autocomplete="off">
          </div>
          <div class="mb-3">
            <label class="form-label">Route (Fill '#' if it has sub menu)</label>
            <input type="text" name="route" class="form-control" required autocomplete="off">
          </div>
          <div class="mb-3 d-none" id="iconContainer">
            <label class="form-label">Icon</label>
            <input type="text" name="icon" class="form-control" placeholder="ex: home, grid">
            <small>Use icon from <a href="https://feathericons.com/" target="_blank">Feather
                Icons</a></small>
          </div>
          <div class="mb-3">
            <label class="form-label">Select Roles Can Access</label>
            <select id="roleSelect" name="roles[]" multiple>
              @foreach (\App\Models\Role::all() as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3 d-none" id="listContainer">
            <label class="form-label">Order</label>
            <input type="number" name="list" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="chooseMenuTypeEditModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Choose Type of Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p>Please choose type of menu:</p>
        <button class="btn btn-primary w-100 mb-2" onclick="openMenuFormEdit('menu')">Main Menu</button>
        <button class="btn btn-secondary w-100" onclick="openMenuFormEdit('submenu')">Sub Menu</button>
      </div>
    </div>
  </div>
</div>

<div id="menuFormEditModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="menuFormEditTitle">Edit Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/menus/update" method="post">
        @csrf
        @method('put')
        <div class="modal-body">
          <input type="hidden" name="type" id="menuTypeEditInput">
          <div class="mb-3" id="mainMenuSelect">
            <label class="form-label">Select Menu</label>
            <select class="form-select" id="mainMenuSelectDropdown">
              <option value="">Select Menu</option>
              @foreach ($menus as $menu)
                <option value="{{ $menu->id }}" data-id="{{ $menu->id }}" data-name="{{ $menu->name }}"
                  data-route="{{ $menu->route }}" data-icon="{{ $menu->icon }}" data-list="{{ $menu->list }}"
                  data-role="{{ json_encode($menu->roles->pluck('id')) }}">
                  {{ $menu->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="mb-3" id="subMenuSelect">
            <label class="form-label">Select Sub Menu</label>
            <select class="form-select" id="subMenuSelectDropdown">
              <option value="">Select Sub Menu</option>
              @foreach ($menus as $menu)
                @foreach ($menu->subMenus as $submenu)
                  <option value="{{ $submenu->id }}" data-id="{{ $submenu->id }}"
                    data-name="{{ $submenu->name }}" data-route="{{ $submenu->route }}"
                    data-menu_id="{{ $submenu->menu_id }}"
                    data-role="{{ json_encode($submenu->roles->pluck('id')) }}">
                    {{ $submenu->name }}
                  </option>
                  @foreach ($submenu->subSubMenus as $subsubmenu)
                    <option value="{{ $subsubmenu->id }}" data-id="{{ $subsubmenu->id }}"
                      data-name="{{ $subsubmenu->name }}" data-route="{{ $subsubmenu->route }}"
                      data-parent_id="{{ $subsubmenu->parent_id }}"
                      data-role="{{ json_encode($subsubmenu->roles->pluck('id')) }}">
                      -- {{ $subsubmenu->name }}
                    </option>
                  @endforeach
                @endforeach
              @endforeach
            </select>
          </div>
          <input type="hidden" name="id" id="menuIdInput" value="">
          <div class="mb-3 d-none" id="parentMenuEditContainer">
            <label class="form-label d-block">Choose Main Menu (Fill in either the Menu ID or Parent
              ID)</label>
            <small>Fill Menu ID if it's a sub menu</small>
            <select name="menu_id" id="menuSelectEdit" class="form-select">
              <option value="">Select Menu ID</option>
              @foreach ($menus as $menu)
                <option value="{{ $menu->id }}">{{ $menu->name }}</option>
              @endforeach
            </select>
            <small>Fill Parent ID if it's a sub-sub menu</small>
            <select name="parent_id" id="parentSelectEdit" class="form-select">
              <option value="">Select Parent ID</option>
              @foreach ($menus as $menu)
                @foreach ($menu->subMenus as $submenu)
                  <option value="{{ $submenu->id }}">{{ $submenu->name }}</option>
                @endforeach
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Menu Name</label>
            <input type="text" name="name" class="form-control" required autocomplete="off">
          </div>
          <div class="mb-3">
            <label class="form-label">Route (Fill '#' if it has sub menu)</label>
            <input type="text" name="route" class="form-control" required autocomplete="off">
          </div>
          <div class="mb-3 d-none" id="iconEditContainer">
            <label class="form-label">Icon</label>
            <input type="text" name="icon" class="form-control" placeholder="ex: home, grid">
            <small>Use icon from <a href="https://feathericons.com/" target="_blank">Feather
                Icons</a></small>
          </div>
          <div class="mb-3">
            <label class="form-label">Select Roles Can Access</label>
            <select id="roleSelectEdit" name="roles[]" multiple>
              @foreach (\App\Models\Role::all() as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3 d-none" id="listEditContainer">
            <label class="form-label">Order</label>
            <input type="number" name="list" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="deleteMenuModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="deleteMenuForm" action="/menus/delete" method="post">
        @csrf
        @method('delete')
        <div class="modal-body">
          <label class="form-label">Select Menu/Sub Menu</label>
          <select class="form-select" name="menu">
            <option value="">Select Menu/Sub Menu</option>
            @foreach ($menus as $menu)
              <option value="{{ $menu->id }}">
                {{ $menu->name }}
              </option>
              @foreach ($menu->subMenus as $submenu)
                <option value="{{ $submenu->id }}">
                  - {{ $submenu->name }}
                </option>
                @foreach ($submenu->subSubMenus as $subsubmenu)
                  <option value="{{ $subsubmenu->id }}">
                    -- {{ $subsubmenu->name }}
                  </option>
                @endforeach
              @endforeach
            @endforeach
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" id="deleteMenuButton" class="btn btn-primary">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    let select = new TomSelect("#roleSelect", {
      plugins: ['remove_button'],
      persist: false,
      create: false,
      placeholder: "Select role...."
    });
  });

  function openChooseMenuModal() {
    var chooseModal = new bootstrap.Modal(document.getElementById('chooseMenuTypeModal'));
    chooseModal.show();
  }

  function openMenuForm(type) {
    var chooseModal = bootstrap.Modal.getInstance(document.getElementById('chooseMenuTypeModal'));
    chooseModal.hide();

    document.getElementById("menuTypeInput").value = type;

    document.getElementById("menuFormTitle").innerText = (type === "menu") ? "Create Main Menu" : "Create Sub Menu";
    let iconContainer = document.getElementById("iconContainer");
    let listContainer = document.getElementById("listContainer");
    if (type === "menu") {
      iconContainer.classList.remove("d-none");
      listContainer.classList.remove("d-none");
    } else {
      iconContainer.classList.add("d-none");
      listContainer.classList.add("d-none");
    }

    let parentContainer = document.getElementById("parentMenuContainer");
    if (type === "submenu") {
      parentContainer.classList.remove("d-none");
    } else {
      parentContainer.classList.add("d-none");
    }

    var menuFormModal = new bootstrap.Modal(document.getElementById('menuFormModal'));
    menuFormModal.show();
  }

  function openChooseMenuEditModal() {
    var chooseModal = new bootstrap.Modal(document.getElementById('chooseMenuTypeEditModal'));
    chooseModal.show();
  }

  function openMenuFormEdit(type) {
    var chooseModal = bootstrap.Modal.getInstance(document.getElementById('chooseMenuTypeEditModal'));
    chooseModal.hide();

    document.getElementById("menuTypeEditInput").value = type;

    document.getElementById("menuFormEditTitle").innerText = (type === "menu") ? "Edit Main Menu" : "Edit Sub Menu";
    let iconEditContainer = document.getElementById("iconEditContainer");
    let listEditContainer = document.getElementById("listEditContainer");
    let mainMenuSelectContainer = document.getElementById("mainMenuSelect");
    if (type === "menu") {
      iconEditContainer.classList.remove("d-none");
      listEditContainer.classList.remove("d-none");
      mainMenuSelectContainer.classList.remove("d-none");
    } else {
      iconEditContainer.classList.add("d-none");
      listEditContainer.classList.add("d-none");
      mainMenuSelectContainer.classList.add("d-none");
    }


    let parentEditContainer = document.getElementById("parentMenuEditContainer");
    let subMenuSelectContainer = document.getElementById("subMenuSelect");
    if (type === "submenu") {
      parentEditContainer.classList.remove("d-none");
      subMenuSelectContainer.classList.remove("d-none");
    } else {
      parentEditContainer.classList.add("d-none");
      subMenuSelectContainer.classList.add("d-none");
    }

    var menuFormEditModal = new bootstrap.Modal(document.getElementById('menuFormEditModal'));
    menuFormEditModal.show();
  }

  document.addEventListener("DOMContentLoaded", function() {
    let menuSelect = document.getElementById("menuSelect");
    let parentSelect = document.getElementById("parentSelect");
    let menuSelectEdit = document.getElementById("menuSelectEdit");
    let parentSelectEdit = document.getElementById("parentSelectEdit");

    menuSelect.addEventListener("change", function() {
      if (menuSelect.value) {
        parentSelect.value = "";
      }
    });

    parentSelect.addEventListener("change", function() {
      if (parentSelect.value) {
        menuSelect.value = "";
      }
    });

    menuSelectEdit.addEventListener("change", function() {
      if (menuSelectEdit.value) {
        parentSelectEdit.value = "";
      }
    });

    parentSelectEdit.addEventListener("change", function() {
      if (parentSelectEdit.value) {
        menuSelectEdit.value = "";
      }
    });
  });
  document.addEventListener("DOMContentLoaded", function() {
    let mainMenuSelect = document.getElementById("mainMenuSelectDropdown");
    let subMenuSelect = document.getElementById("subMenuSelectDropdown");

    let menuIdInput = document.querySelector("#menuFormEditModal input[name='id']");
    let menuNameInput = document.querySelector("#menuFormEditModal input[name='name']");
    let routeInput = document.querySelector("#menuFormEditModal input[name='route']");
    let iconInput = document.querySelector("#menuFormEditModal input[name='icon']");
    let listInput = document.querySelector("#menuFormEditModal input[name='list']");
    let parentMenuInput = document.querySelector("#menuFormEditModal select[name='menu_id']");
    let parentMenuInput2 = document.querySelector("#menuFormEditModal select[name='parent_id']");
    let roleInput = document.querySelector("#menuFormEditModal select[name='roles[]']");

    let roleSelect = new TomSelect(roleInput, {
      plugins: ['remove_button'],
      persist: false,
      create: false
    });

    function updateFormFields(selectedOption) {
      if (selectedOption) {
        menuIdInput.value = selectedOption.dataset.id;
        menuNameInput.value = selectedOption.dataset.name || "";
        routeInput.value = selectedOption.dataset.route || "";
        iconInput.value = selectedOption.dataset.icon || "";
        listInput.value = selectedOption.dataset.list || "";
        parentMenuInput.value = selectedOption.dataset.menu_id || "";
        parentMenuInput2.value = selectedOption.dataset.parent_id || "";
        let roleValues = [];
        if (selectedOption.dataset.role) {
          try {
            roleValues = JSON.parse(selectedOption.dataset.role);
          } catch (e) {
            console.error("Error parsing role data: ", e);
          }
        }
        roleSelect.clear();
        roleSelect.setValue(roleValues);
      }
    }

    mainMenuSelect.addEventListener("change", function() {
      let selectedOption = mainMenuSelect.options[mainMenuSelect.selectedIndex];
      updateFormFields(selectedOption);
    });

    subMenuSelect.addEventListener("change", function() {
      let selectedOption = subMenuSelect.options[subMenuSelect.selectedIndex];
      updateFormFields(selectedOption);
    });
  });

  function deleteMenuModal() {
    var chooseModal = new bootstrap.Modal(document.getElementById('deleteMenuModal'));
    chooseModal.show();
  }

  document.getElementById("deleteMenuButton").addEventListener("click", function(event) {
    event.preventDefault();
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById("deleteMenuForm").submit();
      }
    });
  });
</script>
