<li class="no-phone">
    <a class="icon" href="{{ route('employee.login',['username' => $tenant->username]) }}" data-role="hint" data-hint="Already A Member?" data-hint-background="bg-darkTeal"
        data-hint-color="fg-white">&nbsp;<span class="mif-suitcase fg-lime"></span>  Employee Login</a>
</li>
<li>
    <a class="icon" href="{{ route('client.login',['username' => $tenant->username]) }}" data-role="hint" data-hint="Already A Member?" data-hint-background="bg-darkTeal"
        data-hint-color="fg-white">&nbsp;<span class="mif-profile fg-teal"></span> Client Login</a>
</li>
