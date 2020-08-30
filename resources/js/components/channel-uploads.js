Vue.component('channel-uploads', {
    data() {
        return {
            selected: false
        }
    },
    methods: {
        upload() {
            const videos = this.$refs.videos.files;
            this.selected = true;

            console.log(videos);
        }
    }
});
