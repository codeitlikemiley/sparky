<li class="no-phone">
    <a class="icon" href="{{ route('employee.login',['username' => $tenant->username]) }}" data-role="hint" data-hint="Already A Member?" data-hint-background="bg-darkTeal"
        data-hint-color="fg-white">&nbsp;<span class="mif-enter fg-lime"></span>  Employee Login</a>
</li>
<li class="no-phone">
    <a class="icon" href="{{ route('client.login',['username' => $tenant->username]) }}" data-role="hint" data-hint="Already A Member?" data-hint-background="bg-darkTeal"
        data-hint-color="fg-white">&nbsp;<span class="mif-enter fg-lime"></span> Client Login</a>
</li>
