<template>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li :class="{ disabled: page === 1}">
                <a v-if="page !== 1" href="#" @click.prevent="prevPage" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>

                <span v-else aria-hidden="true">&laquo;</span>
            </li>

            <li v-for="pageNum in pagesCount" :class="{ active: pageNum === page }">
                <a v-if="pageNum !== page" href="#" @click.prevent="setPage(pageNum)" v-text="pageNum"></a>
                <span v-else v-text="pageNum"></span>
            </li>

            <li :class="{ disabled: pagesCount === page }">
                <a v-if="pagesCount !== page" href="#" @click.prevent="nextPage" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>

                <span v-else aria-hidden="true">&raquo;</span>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        props: {
            page: {
                type: Number,
                default: 1
            },

            pagesCount: {
                type: Number,
                default: 1
            }
        },

        methods: {
            prevPage() {
                let page = this.page - 1;

                this.setPage(page);
            },

            nextPage() {
                let page = this.page + 1;

                this.setPage(page);
            },

            setPage(pageNum) {
                this.$emit('page-updated', pageNum);
            }
        }
    }
</script>