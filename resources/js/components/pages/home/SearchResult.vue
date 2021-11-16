<template>
    <div>

        <table v-show="details.specification!==null" class="table table-striped">
            <thead>
                <tr>
                    <td class="bg-indigo-500 text-white h-12 col">
                        <h4 class="pl-1">
                         Vehicle Information
                        </h4>
                    </td>
                    <td class="bg-indigo-500 text-white h-12 col">
                        <h4>
                        </h4>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in details.specification" :key="index">
                    <td>{{index}}</td>
                    <td class="report-value" id="nhtsa-27">{{item }}</td>
                </tr>
            </tbody>
        </table>

        <table v-if="details.salvage != null" class="table table-striped">
            <thead>
                <tr>
                    <td class="bg-indigo-500 text-white h-12 col">
                        <h4 class="pl-1">
                            Salvage Information
                        </h4>
                    </td>
                    <td class="bg-indigo-500 text-white h-12 col">
                        <h4>
                        </h4>
                    </td>
                </tr>
            </thead>
            <div>
                <p></p>
            </div>
            <tbody>
                <tr v-for="(item, index) in details.salvage.info" :key="index">
                    <td>{{index}}</td>
                    <td class="report-value" id="nhtsa-27">{{item }}</td>
                </tr>
            </tbody>
        </table>

    </div>

</template>
<script>

export default {
    props: {
        details: Object,
    }
}
</script>

