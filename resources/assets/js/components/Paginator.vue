<template>
    <ul class="pagination" v-if="shouldPaginate">
        <li v-show="prevUrl">
            <a href="#" aria-label="Previous" rel="prev" @click.prevent="page--">
                <span aria-hidden="true">&laquo; 上一个</span>
            </a>
        </li>
        <li v-show="nextUrl">
            <a href="#" aria-label="Next" rel="next" @click.prevent="page++">
                <span aria-hidden="true">下一个 &raquo;</span>
            </a>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['dataSet'],

        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false
            }
        },

        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },

            page() {
                this.broadcast().updateUrl();
            }
        },

        computed: {
            shouldPaginate() {
                //上一页或者下一页存在的时候，也就是多于一页的时候，要显示分页
                return !! this.prevUrl || !! this.nextUrl;
            }
        },

        methods: {

            //触发页面切换事件，Replies中listen
            broadcast() {
                return this.$emit('changed', this.page);
            },

            //更新输入栏url显示
            updateUrl() {
                history.pushState(null, null, '?page=' + this.page);
            }
        }
    }
</script>
