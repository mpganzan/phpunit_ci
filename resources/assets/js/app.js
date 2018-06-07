import './bootstrap'
import { HasError, AlertError } from 'vform'
import CommentSection from './components/reply/CommentSection'
import DeleteButton from './components/article/DeleteButton'

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(CommentSection.name, CommentSection)
Vue.component(DeleteButton.name, DeleteButton)

const app = new Vue({
    el: '#app'
});
