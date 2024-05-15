import { Address } from "./address"

export type Person = {
    id: number
    public_id: string
    name: string
    alternate_name: string
    document: string
    email: string
    father_name: string
    mother_name: string
    phone: string
    created_at: string
    updated_at: string

    addresses: Address[]
}
