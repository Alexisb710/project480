<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <form id="delete-account-form" method="post" action="{{ route('profile.destroy') }}" class="p-6">
        @csrf
        @method('delete')

        <!-- Delete Account Button -->
        <button type="button" class="btn btn-danger" onclick="confirmAccountDeletion(event)">
            {{ __('Delete Account') }}
        </button>
    </form>
</section>

<!-- SweetAlert2 Library from CDNJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    function confirmAccountDeletion(event) {
        event.preventDefault();

        swal({
            title: "Are you sure?",
            text: "Once your account is deleted, all of your data will be permanently lost.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                // Show additional prompt to enter password
                swal({
                    text: "Please enter your password to confirm deletion:",
                    content: {
                        element: "input",
                        attributes: {
                            placeholder: "Password",
                            type: "password",
                        },
                    },
                    button: {
                        text: "Confirm Delete",
                        closeModal: false,
                    },
                }).then((password) => {
                    if (password) {
                        // Add the password field to the form and submit it
                        const form = document.getElementById('delete-account-form');
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'password';
                        input.value = password;
                        form.appendChild(input);

                        form.submit();
                    } else {
                        swal("Deletion cancelled", "You must enter your password to delete the account", "info");
                    }
                });
            }
        });
    }
</script>
