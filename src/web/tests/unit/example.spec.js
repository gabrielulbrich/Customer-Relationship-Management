import { shallowMount } from '@vue/test-utils'
import Login from '@/views/Login.vue'

describe('Login.vue', () => {
  it('renders props.msg when passed', () => {
    const msg = 'Entrar'
    const wrapper = shallowMount(Login, {
      propsData: { msg }
    })
    expect(wrapper.text()).toMatch(msg)
  })
})
