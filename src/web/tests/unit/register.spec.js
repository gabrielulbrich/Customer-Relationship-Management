import { shallowMount } from '@vue/test-utils'
import Register from '@/views/Register.vue'

describe('Register.vue', () => {
  it('renders props.msg when passed', () => {
    const msg = 'Cadastre-se'
    const wrapper = shallowMount(Register, {
      propsData: { msg }
    })
    expect(wrapper.text()).toMatch(msg)
  })
})