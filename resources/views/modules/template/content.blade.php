<div class="content">
        <div class="text">
            <div class="row cells12">
                <div class="cell colspan12">
                    <div class="tabcontrol" data-role="tabcontrol">
                        <ul class="tabs">
                            <li><a href="#template_tab">Pre-Built Templates</a></li>
                            <!-- <li><a href="#onboarding_tab" v-if="guard ==='web'">Forms</a></li> -->
                        </ul>
                        <div class="frames bg-white" v-if="templates.length > 0" style="min-height:500px;padding-bottom:100px;">
                            @include('template::tab')
                        </div>
                        <div class="frames bg-white" v-else style="padding-bottom:100px;">
                            <h2 class="fg-teal align-center"><span class="tag bg-red fg-white">No Available Templates.</span></h2>
                            <h2 class="fg-teal align-center" style="padding-bottom:250px;"><span class="tag success" @click="goToDashboard()" style="cursor:pointer;">Create Project First Then Clone It.</span></h2>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>