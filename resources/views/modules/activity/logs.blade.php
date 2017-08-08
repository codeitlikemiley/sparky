<div class="cell" v-if="activities.length >0">
        <div class="panel widget-box warning" data-role="panel">
            <div class="heading align-center">
                <div class="title">Activity Logs</div>
            </div>
            <div class="content">
                <ul class="timeline-list" v-if="activities.length > 0">
                    <li v-for="(activity, activityKey) in activities" v-if="Object.keys(activity.properties.attributes).length > 0">
                        <div class="date">
                            <span class="icon fa fa-briefcase"></span>
                            <small>@{{ activity.updated_at | relative }} ago</small>
                        </div>
                        <h5 >@{{ activity.description }}</h5>
                        <div class="content">
                            <ul v-for="(attributes,attributesKey) in activity.properties">
                                <li v-for="(property,propertyKey) in attributes" v-if="activity.properties.attributes[propertyKey]">@{{ propertyKey }} - <span v-if="activity.properties.old"> from: @{{ activity.properties.old[propertyKey] }}</span><span> to: @{{ property }}</span> </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>