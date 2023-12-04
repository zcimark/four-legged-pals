import { createRouter, createWebHistory } from 'vue-router'
import CatView from '../views/CatView.vue'
import DogView from '../views/DogView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/cat',
      name: 'cat',
      component: CatView
    },
    {
      path: '/dog',
      name: 'dog',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: DogView
    }
  ]
})

export default router
