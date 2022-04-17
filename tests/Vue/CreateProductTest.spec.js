// Import the `mount()` method from Vue Test Utils
import { mount } from '@vue/test-utils'
import CreateComponent from '@/components/CreateComponent.vue'

test("add product", ()=>{
    const wrapper = mount(CreateComponent);
    const result = wrapper.vm.addProduct();
    expect(result).toBe(' ');
});