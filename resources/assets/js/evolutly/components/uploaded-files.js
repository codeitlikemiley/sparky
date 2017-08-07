Vue.component('uploaded-files', {
    props: ['tenant', 'guard'],
    data () {
        return {
            files: [],
        }
    },

    mounted() {
        console.log('uploaded files component loaded!')
        this.fetchUploadedFiles()
    },
    computed: {
        
    },
    methods: { 
        fileChunks(files) {
            return _.chunk(files, 3)
        },
        getSourceFile(file) {
            return `${window.location.protocol}//${window.location.hostname}/${file.path}${file.filename}.${file.extension}`
        },
        getImageByExtension(file) {
            let images = ['png','jpeg','gif','bmp', 'tiff','exif']
            let pdf = ['pdf','epub','mobi']
            let docs = ['doc','dot','docx','dotx','odt']
            let xls = ['xls','xlt','xla', 'xlsx', 'xltx', 'xlsm', 'xltm', 'xlam', 'xlsb']
            let ppt = ['ppt','pot','pps','ppa','pptx','potx','ppsx','ppam','pptm','potm','ppsm']
            let psd = ['psd']
            if(_.includes(images,file.extension)){
                return `${file.path}${file.filename}.${file.extension}`
            }else if(_.includes(pdf,file.extension)){
                return 'https://visual-integrity.com/wp-content/uploads/2016/02/pdf-page.png'
            }else if(_.includes(docs,file.extension)){
                return 'https://davescomputertips.com/wp-content/uploads/2014/03/microsoft-word-logo.jpg'
            } else if(_.includes(xls,file.extension)){
                return  'https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Microsoft_Excel_2013_logo.svg/2000px-Microsoft_Excel_2013_logo.svg.png'
            }else if(_.includes(ppt,file.extension)){
                return 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Microsoft_PowerPoint_2013_logo.svg/1043px-Microsoft_PowerPoint_2013_logo.svg.png'
            }else if(_.includes(psd,file.extension)){
              return  'https://blogsimages.adobe.com/conversations/files/2012/03/Photoshop-CS6-Icon.jpg'
            }
                return 'http://4vector.com/i/free-vector-text-file-icon_101919_Text_File_Icon.png'

        },
        editFile(file){
            console.log('file edited', file)
        },
        deleteFile(file){
            console.log('file deleted', file)
        },
        fetchUploadedFiles(){
            let pathArray = window.location.pathname.split( '/' );
            let projectID = null
            let self = this
            if(this.guard === 'web'){
            projectID = pathArray[3];
            axios.get('/files/show/'+ projectID).then((response) => {
                self.files = response.data
            }) 
            }else if(this.guard === 'employee'){
            projectID = pathArray[4];
            axios.get('/team/files/show/'+ projectID).then((response) => {
                self.files = response.data
            })
            }else if(this.guard === 'client'){
            projectID = pathArray[4];
            axios.get('/client/files/show/'+ projectID).then((response) => {
                self.files = response.data
            })
            }
             
        },
        pushNewUpload(){

        }
    }
});
