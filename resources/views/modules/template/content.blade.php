<div class="content">
        <div class="text">
            <div class="row cells12">
                <div class="cell colspan12">
                    <div class="tabcontrol" data-role="tabcontrol">
                        <ul class="tabs">
                            <li><a href="#template_tab">Pre-Built Templates</a></li>
                            <!-- <li><a href="#onboarding_tab" v-if="guard ==='web'">Forms</a></li> -->
                        </ul>
                        <div class="frames bg-white">
                            @include('template::tab')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>