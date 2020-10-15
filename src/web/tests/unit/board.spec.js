import { shallowMount } from '@vue/test-utils'
import Board from '@/views/Crm/Board/Board.vue'

describe('Board.vue', () => {
  it('renders props.msg when passed', () => {
    const msg = 'ABERTO EM PROGRESSO FINALIZADO'
    const wrapper = shallowMount(Board, {
      propsData: { msg }
    })
    expect(wrapper.text()).toMatch(msg)
  })
})